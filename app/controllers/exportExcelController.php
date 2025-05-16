<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';
require_once BASE_PATH . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportExcelController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function exportExecute()
    {
        $this->authorise();

        $stmt = $this->pdo->prepare("
            SELECT 
                m.name AS media_name,
                g.name AS genre_name,
                t.name AS type_name,
                u.username AS user_name,
                m.year,
                m.duration,
                m.episodes_count
            FROM media m
            JOIN genres g ON m.genre_id = g.id
            JOIN types t ON m.type_id = t.id
            JOIN users u ON m.user_id = u.id
            WHERE m.user_id = ?
        ");

        $stmt->execute([$this->user['id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $columns = ['media_name', 'genre_name', 'type_name', 'user_name', 'year', 'duration', 'episodes_count'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Заглавия
        $sheet->fromArray($columns, null, 'A1');

        // Данни
        $rowNum = 2;
        foreach ($rows as $row) {
            $line = [];
            foreach ($columns as $col) {
                $line[] = $row[$col];
            }
            $sheet->fromArray($line, null, 'A' . $rowNum++);
        }

        // Изпращане на файла
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="media_export.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;

    }
        
}