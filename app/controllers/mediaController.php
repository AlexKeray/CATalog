<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class MediaController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function personalMediaShow()
    {
        $this->authorise();
        
        $this->loadPersonalMedia();

        $this->smarty->display('personal_media.tpl');
    }

    private function loadPersonalMedia()
    {
        try {
            $stmt = $this->pdo->prepare('
                SELECT m.*, g.name AS genre_name, t.name AS type_name
                FROM media m
                JOIN genres g ON m.genre_id = g.id
                JOIN types t ON m.type_id = t.id
                WHERE m.user_id = ?
                ORDER BY m.id ASC
            ');

            $stmt->execute([$this->user['id']]);

            $media = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->smarty->assign('media', $media);
        } catch (PDOException $e) {
            $this->printException($e);
        }
    }
}