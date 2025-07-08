<?php
require_once BASE_PATH . '/app/controllers/common/BaseController.php';
require_once BASE_PATH . '/vendor/autoload.php';

use Mpdf\Mpdf;

class ExportPdfController extends BaseController
{
    private string $fallbackPath;

    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);

        // Вече е в storage/images/
        $this->fallbackPath = BASE_PATH . '/storage/images/questionWhite.png';

        if (!file_exists($this->fallbackPath)) {
            die("Fallback image NOT FOUND at: " . $this->fallbackPath);
        }
    }

    public function exportExecute()
    {

        $this->authorise(); // Увери се, че е защитено

        $stmt = $this->pdo->prepare("
            SELECT m.name, m.image_path, m.year, m.duration, m.episodes_count,
                t.name AS type_name, g.name AS genre_name
            FROM media m
            LEFT JOIN types t ON m.type_id = t.id
            LEFT JOIN genres g ON m.genre_id = g.id
            WHERE m.user_id = ?
        ");
        $stmt->execute([$this->user['id']]);
        $mediaItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $html = '<h1 style="text-align: center;">Колекция</h1>';

        foreach ($mediaItems as $item) {
            $imagePath = $this->resolveImagePath($item['image_path']);
            $imageBase64 = $this->resizeAndEncodeImage($imagePath);

            $name = !empty($item['name']) ? htmlspecialchars($item['name']) : '???';
            $type = !empty($item['type_name']) ? htmlspecialchars($item['type_name']) : '???';
            $genre = !empty($item['genre_name']) ? htmlspecialchars($item['genre_name']) : '???';
            $year = !empty($item['year']) ? $item['year'] : '???';
            $duration = !empty($item['duration']) ? $item['duration'] : '???';
            $episodes = !empty($item['episodes_count']) ? $item['episodes_count'] : '???';

            $html .= '
                <div style="margin-bottom: 25px; border-bottom: 1px solid #ccc; padding-bottom: 15px;">
                    <img src="' . $imageBase64 . '" style="height: 120px; float: left; margin-right: 15px;">
                    <div style="overflow: hidden;">
                        <strong>' . $name . '</strong><br>
                        Тип: ' . $type . '<br>
                        Жанр: ' . $genre . '<br>
                        Година: ' . $year . '<br>
                        Продължителност: ' . $duration . ' мин.<br>';

            if ($type === 'Сериал') {
                $html .= 'Епизоди: ' . $episodes . '<br>';
            }

            $html .= '</div><div style="clear: both;"></div></div>';
        }

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('CATalogPersonalMedia.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }


    private function resolveImagePath(?string $path): string
    {
        if (!$path) {
            return $this->fallbackPath;
        }

        $fullPath = BASE_PATH . DIRECTORY_SEPARATOR . $path;

        // Вземаме разширението
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

        // Ако е неподдържано – fallback
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($extension, $allowedExtensions)) {
            return $this->fallbackPath;
        }

        return file_exists($fullPath) ? $fullPath : $this->fallbackPath;
    }


    private function resizeAndEncodeImage(string $path, int $maxWidth = 120, int $quality = 75): string
    {
        if (!file_exists($path)) {
            $path = $this->fallbackPath;
        }

        [$origWidth, $origHeight, $imageType] = @getimagesize($path);
        if (!$origWidth || !$origHeight) {
            return ''; // защитено: няма да хвърли грешка
        }

        $ratio = $origWidth / $maxWidth;
        $newWidth = $maxWidth;
        $newHeight = (int)($origHeight / $ratio);

        $image = match ($imageType) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG  => @imagecreatefrompng($path),
            IMAGETYPE_GIF  => @imagecreatefromgif($path),
            default => null,
        };

        if (!$image) {
            return '';
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        ob_start();
        imagejpeg($resized, null, $quality);
        return 'data:image/jpeg;base64,' . base64_encode(ob_get_clean());
    }
}
?>