<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';
require_once BASE_PATH . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet; // new Spreadsheet() вместо PhpOffice\PhpSpreadsheet\Spreadsheet, като namespace, Spreadsheet е клас
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; // този обект създава файл от Spreadsheet

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
            LEFT JOIN genres g ON m.genre_id = g.id
            JOIN types t ON m.type_id = t.id
            JOIN users u ON m.user_id = u.id
            WHERE m.user_id = ?
            ORDER BY m.id
        ");

        $stmt->execute([$this->user['id']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Имена на колоните
        $columns = ['media_name', 'genre_name', 'type_name', 'user_name', 'year', 'duration', 'episodes_count'];  // Какзвам как ще се казват колоите

        // Създаване на spreadsheet обект
        $spreadsheet = new Spreadsheet(); // обект който се съпоставя на екселски файл
        $sheet = $spreadsheet->getActiveSheet(); // sheet от екселски файл

        // Писане на заглавията на колони в spreadsheet-а
        $sheet->fromArray($columns, null, 'A1'); // така пишеш хоризонтално започващо от А1

        // Данни
        $rowNum = 2; // A2, А3 и надолу
        foreach ($rows as $row) {
            $line = [];
            foreach ($columns as $col) {
                $line[] = $row[$col]; // $row['media_name'] и тн, $line[] = append-ва
            }
            $sheet->fromArray($line, null, 'A' . $rowNum++);
        }

        // Изпращане на файла
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // казва че е excel файл
        header('Content-Disposition: attachment;filename="media_export.xlsx"'); // Казва да го свали
        header('Cache-Control: max-age=0'); // Инструктира браузъра да не кешира файла, за да се получава винаги нова версия при всяко сваляне

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');  // това слага екселският файл в отговора на клиентската заявка който пхп сървъра ще върне на браузъра на потребителя, като echo-то е
        exit; // след exit няма повече изпълнение на код за тази клиентска заявка

    }
        
}