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
                // проверка дали има такъв жанр
                $checkStmt = $this->pdo->prepare("SELECT id FROM genres WHERE name = ? LIMIT 1");
                $checkStmt->execute([$name]);

                // ако има кофти
                if ($checkStmt->fetch()) {
                    echo json_encode(['message' => 'Жанр с това име вече съществува.']);
                    // http_response_code(400);
                    return;
                }
                
                // ако не insert-ваме новия жанр
                $stmt = $this->pdo->prepare("INSERT INTO genres (name, description, user_id) VALUES (?, ?, ?)");
                $stmt->execute([$name, $description, $this->user['id']]);
                $id = $this->pdo->lastInsertId(); // ВЗИМАМЕ ID-то

                echo json_encode([
                    'success' => true,
                    'id' => $id,
                    'message' => 'Жанрът е създаден.'
                ]);
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
                // Проверяваме дали потребителя е направи жанра
                $stmt = $this->pdo->prepare("SELECT name, description FROM genres WHERE id = ? AND user_id = ?");
                $stmt->execute([$id, $this->user['id']]);
                $existing = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$existing) {
                    http_response_code(403);
                    echo json_encode([
                        'success' => false,
                        'status' => 'unauthorized',
                        'message' => 'Нямаш достъп до този жанр.'
                    ]);
                    return;
                }

                // Проверяваме дали има изобщо нанесени промени
                if ($existing['name'] === $name && $existing['description'] === $description) {
                    echo json_encode([
                        'success' => true,
                        'status' => 'no_change',
                        'message' => 'Няма направени промени.'
                    ]);
                    return;
                }

                // Update-ваме
                $stmt = $this->pdo->prepare("UPDATE genres SET name = ?, description = ? WHERE id = ? AND user_id = ?");
                $stmt->execute([$name, $description, $id, $this->user['id']]);

                echo json_encode([
                    'success' => true,
                    'status' => 'updated',
                    'message' => 'Жанрът е редактиран.'
                ]);
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
                // Трием запис който е на потребителя
                $stmt = $this->pdo->prepare("DELETE FROM genres WHERE id = ? AND user_id=?");
                $stmt->execute([$id, $this->user['id']]);
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Жанрът е изтрит.']);
                } else {
                    http_response_code(403);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Нямаш право да изтриеш този жанр или не съществува.'
                    ]);
                }
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
