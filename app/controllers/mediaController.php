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
        
        $this->laodTypes();
        $this->laodGenres();
        $this->loadPersonalMedia();

        $pageName = 'personal_media';

        $this->smarty->assign('pageName', $pageName);

        $this->smarty->display('personal_media.tpl');
    }

    private function loadPersonalMedia()
    {
        try {
            $stmt = $this->pdo->prepare('
                SELECT m.*, g.name AS genre_name, t.name AS type_name
                FROM media m
                LEFT JOIN genres g ON m.genre_id = g.id
                LEFT JOIN types t ON m.type_id = t.id
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

    public function uploadExecute()
    {

        $this->authorise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $typeId = $_POST['type-id'] ?? null;
            $typeId = $this->nullIfEmpty($typeId);

            try {
                $typeStmt = $this->pdo->prepare('SELECT name FROM types WHERE id = ?');
                $typeStmt->execute([$typeId]);
            } catch (Exception $e) {
                $this->printException($e);
                return;
            }

            // проверява дали има такъв тип
            $typeRecord = $typeStmt->fetch(); // връща 1 ред
            $typeName = $typeRecord ? $typeRecord['name'] : null;
            $typeName = $this->nullIfEmpty($typeName);
            

            $genreRaw = $_POST['genre'] ?? null;
            $genreRaw = $this->nullIfEmpty($genreRaw);

            $genreId = null;

            if (str_starts_with($genreRaw, '__new__:')) {
                $newGenreName = trim(substr($genreRaw, 8)); // 9ти символ и нататък

                // проверка дали жанрът съществува
                $check = $this->pdo->prepare('SELECT id FROM genres WHERE name = ?');
                $check->execute([$newGenreName]);
                $genreId = $check->fetchColumn();

                if (!$genreId) {
                    $insertGenre = $this->pdo->prepare('INSERT INTO genres (name, description, user_id) VALUES (?, "", ?)');
                    $insertGenre->execute([$newGenreName, $this->user['id']]);
                    $genreId = $this->pdo->lastInsertId();
                }
            } else {
                $genreId = $genreRaw;
            }


            $name = trim($_POST['name'] ?? null);
            $name = $this->nullIfEmpty($name);
            $year = $_POST['year'] ?? null;
            $year = $this->nullIfEmpty($year);
            $episodesCount = ($typeName === 'Сериал' && isset($_POST['episodes_count'])) ? (int)$_POST['episodes_count'] : null;
            $episodesCount = $this->nullIfEmpty($episodesCount);
            $duration = $_POST['duration'] ?? null;
            $duration = $this->nullIfEmpty($duration);

            if (empty($name) || empty($typeId)) {
                $this->setAlert(Alert::EmptyRequiredFields, AlertType::Warning);
                $this->personalMediaShow(); // редиректва
                return;
            }

            $posterUrl = $_POST['poster_url'] ?? null;
            $posterUrl = $this->nullIfEmpty($posterUrl);

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
            elseif ($posterUrl) {
                $uploadDir = BASE_PATH . '/storage/images/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $imageData = @file_get_contents($posterUrl); // взима се от апито
                if ($imageData) {
                    $extension = pathinfo(parse_url($posterUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                    $fileName = uniqid() . '.' . ($extension ?: 'jpg');
                    $fullPath = $uploadDir . $fileName;
                    file_put_contents($fullPath, $imageData);
                    $imagePath = 'storage/images/' . $fileName;
                }
            }

            try {
                $stmt = $this->pdo->prepare('
                    INSERT INTO media (type_id, genre_id, name, image_path, year, episodes_count, duration, user_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ');
                

                $stmt->execute([
                    $typeId,
                    $genreId,
                    $name,
                    $imagePath,
                    $year,
                    $episodesCount,
                    $duration,
                    $this->user['id']
                ]);

                $this->setAlert(Alert::MovieAddedSuccessfull, AlertType::Success);

                $this->redirect(BASE_URL . '/personal-media.php');

            } catch (PDOException $e) {
                $this->printException($e);
                $this->uploadSpersonalMediaShowhow();
            }
        } else {
            $this->redirect(BASE_URL . '/upload.php');
        }
    }

    public function editShow($mediaId)
    {
        $this->authorise();

        try {
            $stmt = $this->pdo->prepare('SELECT * FROM media WHERE id = ? AND user_id = ?');
            $stmt->execute([$mediaId, $this->user['id']]);
        } catch (PDOException $e) {
            $this->printException($e);
            return;
        }
        $media = $stmt->fetch();

        $this->smarty->assign('media', $media);
        $this->laodTypes();
        $this->laodGenres();

        $this->smarty->display('edit.tpl');
    }

    public function editExecute()
    {
        $this->authorise();

        $id = $_POST['media_id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $type = $_POST['type-id'] ?? null;
        $genre = $this->nullIfEmpty($_POST['genre'] ?? null);
        $year = $_POST['year'] ?? null;
        $year = $this->nullIfEmpty($year);
        $duration = $_POST['duration'] ?? null;
        $duration = $this->nullIfEmpty($duration);
        $episodes = $_POST['episodes_count'] ?? null;
        $episodes = $this->nullIfEmpty($episodes);

         // Вземаме пътя на текущата снимка от базата
        $stmt = $this->pdo->prepare("SELECT image_path FROM media WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $this->user['id']]);
        $current = $stmt->fetch();
        $imagePath = $current ? $current['image_path'] : null;

        // Ако има нова снимка я качваме
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
            $stmt = $this->pdo->prepare("
                UPDATE media 
                SET name = ?, type_id = ?, genre_id = ?, year = ?, duration = ?, episodes_count = ?, image_path = ?
                WHERE id = ? AND user_id = ?
            ");

            $stmt->execute([
                $name, $type, $genre, $year, $duration, $episodes, $imagePath, $id, $this->user['id']
            ]);
        } catch (Exception $e) {
            $this->printException($e);
            return;
        }

        $this->setAlert(Alert::MovieEditedSuccessfull, AlertType::Success);
        $this->redirect(BASE_URL . '/personal-media.php');
    }

    public function deleteExecute()
    {
        $this->authorise();

        $mediaId = $_POST['id'] ?? null; // id на филм

        if (!$mediaId) {
            http_response_code(400); // липсва id
            return;
        }

        try {
            $stmt = $this->pdo->prepare('DELETE FROM media WHERE id = ? AND user_id = ?');
            $stmt->execute([$mediaId, $this->user['id']]);

            if ($stmt->rowCount() === 0) {
                http_response_code(403); // не е правилният потребител
                return;
            }

            http_response_code(200);
        } catch (PDOException $e) {
            $this->printException($e);
            http_response_code(500); // някаква грешка
        }
    }

    private function laodGenres()
    {
        try {
            $stmt = $this->pdo->prepare('SELECT id, name, description, user_id FROM genres ORDER BY name');
            $stmt->execute();
            $allGenres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->smarty->assign('allGenres', $allGenres);

            $stmt = $this->pdo->prepare('SELECT id, name, description FROM genres WHERE user_id = ? ORDER BY name');
            $stmt->execute([$this->user['id']]);
            $userGenres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->smarty->assign('userGenres', $userGenres);
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