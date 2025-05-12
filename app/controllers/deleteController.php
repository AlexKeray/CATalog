<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class DeleteController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function deleteExecute()
    {
        $this->authorise();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mediaId'])) {
            $mediaId = (int)$_POST['mediaId'];

            try {
                $stmt = $this->pdo->prepare("DELETE FROM media WHERE id = ? AND user_id = ?");
                $stmt->execute([$mediaId, $this->user['id']]);
                http_response_code(200);
            } catch (PDOException $e) {
                $this->printException($e);
                http_response_code(500);
            }
        } else {
            http_response_code(400);
        }
    }

}