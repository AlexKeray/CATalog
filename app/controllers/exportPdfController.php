<?php
require_once BASE_PATH . '/app/controllers/common/BaseController.php';
require_once BASE_PATH . '/vendor/autoload.php'; // за библиотеката в композитора

use Mpdf\Mpdf;

class ExportPdfController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function exportExecute()
    {
        $this->authorise();

        $stmt = $this->pdo->prepare("SELECT name, year, duration, episodes_count, image_path, 
            (SELECT name FROM types WHERE id = media.type_id) AS type_name,
            (SELECT name FROM genres WHERE id = media.genre_id) AS genre_name
        FROM media WHERE user_id = ?");
        $stmt->execute([$this->user['id']]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $mpdf = new \Mpdf\Mpdf();

        // Стилове
        $mpdf->WriteHTML('<style>
            .media-block { margin-bottom: 30px; page-break-inside: avoid; }
            .media-image { width: 200px; margin-bottom: 10px; }
            .separator { border-top: 2px solid #000; margin: 15px 0; }
            .title { font-size: 20px; font-weight: bold; }
        </style>');

        foreach ($rows as $row) {
            $imagePath = BASE_PATH . '/' . $row['image_path'];
            $imgHtml = '';

            if (file_exists($imagePath)) {
                $base64 = base64_encode(file_get_contents($imagePath));
            } else {
                $fallbackPath = BASE_PATH . '/misc/question.jpg';
                $base64 = base64_encode(file_get_contents($fallbackPath));
            }

            $imgHtml = '<img src="data:image/jpeg;base64,' . $base64 . '" class="media-image">';

            $blockHtml = '<div class="media-block">';
            $blockHtml .= '<div class="separator"></div>';
            $blockHtml .= $imgHtml;
            $blockHtml .= '<div class="title">' . htmlspecialchars($row['name']) . '</div>';
            $blockHtml .= '<div>Тип: ' . htmlspecialchars($row['type_name']) . '</div>';
            $blockHtml .= '<div>Жанр: ' . htmlspecialchars($row['genre_name']) . '</div>';
            $blockHtml .= '<div>Година: ' . htmlspecialchars($row['year']) . '</div>';
            if (mb_strtolower($row['type_name']) === 'сериал') {
                $blockHtml .= '<div>Брой епизоди: ' . htmlspecialchars($row['episodes_count']) . '</div>';
            }
            $blockHtml .= '<div>Продължителност: ' . htmlspecialchars($row['duration']) . '</div>';
            $blockHtml .= '</div>';

            $mpdf->WriteHTML($blockHtml);
        }

        $mpdf->Output('CATalogMedia.pdf', 'D');
        exit;
    }
}





?>