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

        $this->fallbackPath = BASE_PATH . '/storage/images/questionWhite.png';  // Винаги в images трябва да стои default снимката дето е въпросителен.

        if (!file_exists($this->fallbackPath)) {
            die("Fallback image NOT FOUND at: " . $this->fallbackPath); // die е като exit ама връща и съобщение
        }
    }

    public function exportExecute()
    {

        $this->authorise(); // redirect-ва към login-а

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

        $html = '<h1 style="text-align: center;">Твоите филми и сериали.</h1>';

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


    private function resolveImagePath(?string $path): string // ?string е стринг или null, : string е return type-а, винаги стои отзад
    {
        if (!$path) {
            return $this->fallbackPath;
        }

        $fullPath = BASE_PATH . DIRECTORY_SEPARATOR . $path;

        //разширението
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

        // Ако не е поддържано – fallback
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

        $info = getimagesize($path); // вградено в пхп, чете инфо от даден файл

        if ($info === false) {
            return ''; // Невалидно изображение или липсва файл
        }

        $origWidth = $info[0];
        $origHeight = $info[1];
        $imageType = $info[2];

        // някакви сметки за да се запазят пропорциите въпреки оразмеряването
        $ratio = $origWidth / $maxWidth;
        $newWidth = $maxWidth;
        $newHeight = (int)($origHeight / $ratio);

        $image = null;

        switch ($imageType) {  // @ подтиска warning-и
            case IMAGETYPE_JPEG:
                $image = @imagecreatefromjpeg($path);  // трябва ни специален формат на image ресурс за да можем да го обработваме с следващите функции
                break;
            case IMAGETYPE_PNG:
                $image = @imagecreatefrompng($path);
                break;
            case IMAGETYPE_GIF:
                $image = @imagecreatefromgif($path);
                break;
        }

        if (!$image) {
            return '';
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);  // нужно е ама нз защо

        imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight); // използва се за преоразмеряване

        ob_start(); // стартира буфер, тоест всичко от рода на echo отива там а не в браузъра
        imagejpeg($resized, null, $quality); // генерира jpeg
        return 'data:image/jpeg;base64,' . base64_encode(ob_get_clean());
        // ob_get_clean() Взима всичко, което е събрано в output буфера (т.е. JPEG изображението), и затваря буфера
        // base64_encode() Кодира бинарните данни на изображението в base64 текст, подходящ за HTML
        // data:image/jpeg;base64 всяко base64 изображение трябва да започва така
    }
}
?>