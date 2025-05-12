<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class HomeController extends BaseController {

    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function homeShow()
    {
        $this->assignUser();

        $this->loadMedia();

        $this->smarty->display('home.tpl');
    }

    private function loadMedia()
    {
        try {
            $stmt = $this->pdo->query('
                SELECT m.*, g.name AS genre_name, t.name AS type_name
                FROM media m
                JOIN genres g ON m.genre_id = g.id
                JOIN types t ON m.type_id = t.id
                ORDER BY m.id ASC
            ');

            $media = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->smarty->assign('media', $media);
        } catch (PDOException $e) {
            $this->printException($e);
        }
    }

}



?>