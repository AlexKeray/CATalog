<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class UploadController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function uploadShow()
    {
        //$this->assignUser();

        // if ($this->user === null) {
        //     $this->redirect(BASE_URL . '/login.php');
        //     return;
        // }

        $this->authorise();

        // try {
        //     $stmt = $this->pdo->query('SELECT id, name FROM genres ORDER BY name');
        //     $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //     $this->smarty->assign('genres', $genres);
        // } catch (PDOException $e) {
        //     $this->printException($e);
        // }

        $this->laodTypes();
        $this->laodGenres();
   

        $this->smarty->display('upload.tpl');
    }

    public function uploadExecute()
    {
        //$this->assignUser();

        // if ($this->user === null) {
        //     $this->redirect(BASE_URL . '/login.php');
        //     return;
        // }

        $this->authorise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $typeId = $_POST['type'] ?? '';
            $genreId = $_POST['genre'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $year = $_POST['year'] ?? '';
            $duration = $_POST['duration'] ?? '';

            if (empty($genreId) || empty($name) || empty($year) || empty($duration)) {
                $this->setAlert(Alert::AllFieldsRequired, AlertType::Warning);
                $this->uploadShow();
                return;
            }

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = BASE_PATH . '/storage/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
                $fullPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
                    $imagePath = 'storage/images/' . $fileName;
                }
            }

            try {
                $stmt = $this->pdo->prepare('
                    INSERT INTO media (type_id, genre_id, name, image_path, year, duration, user_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ');
                $stmt->execute([
                    $typeId,
                    $genreId,
                    $name,
                    $imagePath,
                    $year,
                    $duration,
                    $this->user['id']
                ]);

                $this->setAlert(Alert::MovieAddedSuccessfull, AlertType::Success);

                $this->redirect(BASE_URL . '/home.php');

            } catch (PDOException $e) {
                $this->printException($e);
                $this->uploadShow();
            }
        } else {
            $this->redirect(BASE_URL . '/upload.php');
        }
    }

    private function laodGenres()
    {
        try {
            $stmt = $this->pdo->query('SELECT id, name FROM genres ORDER BY name');
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
