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

        if ($this->user === null) {
            $this->smarty->display('home.tpl');
            return;
        }

        try {
            $stmt = $this->pdo->query('
                SELECT 
                    movies.id,
                    movies.name,
                    movies.image_path,
                    movies.year,
                    movies.duration,
                    genres.name AS genre_name
                FROM movies
                JOIN genres ON movies.genre_id = genres.id
                ORDER BY movies.id ASC
            ');

            $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->smarty->assign('movies', $movies);
        } catch (PDOException $e) {
            $this->printException($e);
        }

        $this->smarty->display('home.tpl');
    }

}

?>