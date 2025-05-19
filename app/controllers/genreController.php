<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class GenreController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function createExecute()
    {
        $this->authorise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            $name = trim($_POST['name']);
            $description = trim($_POST['description'] ?? '');

            if ($name === '') {
                http_response_code(400);
                echo json_encode(['message' => 'Името е задължително.']);
                return;
            }

            try {
                $stmt = $this->pdo->prepare("INSERT INTO genres (name, description) VALUES (?, ?)");
                $stmt->execute([$name, $description]);
                echo json_encode(['message' => 'Жанрът е създаден.']);
            } catch (PDOException $e) {
                $this->printException($e);
                http_response_code(500);
            }
        } else {
            http_response_code(400);
        }
    }

    public function editExecute()
    {
        $this->authorise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['name'])) {
            $id = (int)$_POST['id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description'] ?? '');

            try {
                $stmt = $this->pdo->prepare("UPDATE genres SET name = ?, description = ? WHERE id = ?");
                $stmt->execute([$name, $description, $id]);
                echo json_encode(['message' => 'Жанрът е редактиран.']);
            } catch (PDOException $e) {
                $this->printException($e);
                http_response_code(500);
            }
        } else {
            http_response_code(400);
        }
    }

    public function deleteExecute()
    {
        $this->authorise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = (int)$_POST['id'];

            try {
                $stmt = $this->pdo->prepare("DELETE FROM genres WHERE id = ?");
                $stmt->execute([$id]);
                echo json_encode(['success' => true, 'message' => 'Жанрът е изтрит.']);
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') { // foreign key constraint violation
                    http_response_code(409); // Conflict
                    echo json_encode([
                        'success' => false,
                        'message' => 'Жанрът не може да бъде изтрит, защото се използва от медия.'
                    ]);
                }
                else {
                    http_response_code(500);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Възникна неочаквана грешка.'
                    ]);
                }
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Невалидна заявка.']);
        }
    }
}
