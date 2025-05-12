<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class LoginController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function loginShow()
    {
        $this->smarty->display('login.tpl');
    }

    public function loginExecute()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            try {
                $stmt = $this->pdo->prepare(
                    'SELECT id, username, password FROM users WHERE username = ? LIMIT 1'
                );
                $stmt->execute([$username]);
                $dbUser = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($dbUser && password_verify($password, $dbUser['password'])) {
                    $_SESSION['user'] = [
                        'id' => $dbUser['id'],
                        'username' => $dbUser['username']
                    ];

                    $this->redirect(BASE_URL . '/home.php');
                } else {
                    $this->setAlert(Alert::LoginCredFailed, AlertType::Warning);
                    $this->smarty->assign('old_username', htmlspecialchars($username));
                    $this->smarty->display('login.tpl');
                }
            } catch (PDOException $e) {

                $this->printException($e);

                $this->smarty->display('login.tpl');
            }
        } else {
            $this->redirect(BASE_URL .  '/login.php');
        }
    }
}