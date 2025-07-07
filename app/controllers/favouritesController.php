<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class FavouritesController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function favouritesShow()
    {
        $this->authorise();
        
        $this->laodTypes();
        $this->laodGenres();
        $this->loadPersonalMedia();

        $pageName = 'favourites';
        $this->smarty->assign('pageName', $pageName);

        $this->smarty->display('favourites.tpl');
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

            $editMode = true;
            $this->smarty->assign('editMode', $editMode);

        } catch (PDOException $e) {
            $this->printException($e);
        }
    }

        private function laodGenres()
    {
        try {
            $stmt = $this->pdo->query('SELECT id, name, description FROM genres ORDER BY name');
            $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->smarty->assign('genres', $genres);
        } catch (PDOException $e) {
            $this->printException($e);
        }
    }

    private function laodTypes()
    {
        try {
            $stmt = $this->pdo->query('SELECT id, name FROM types ORDER BY name');
            $types = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->smarty->assign('types', $types);
        } catch (PDOException $e) {
            $this->printException($e);
        }
    }
}