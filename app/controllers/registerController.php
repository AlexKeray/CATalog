<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class RegisterController extends BaseController
{
    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function registerShow()
    {
        $this->assignUser();

        if ($this->user !== null) {
            $this->redirect(BASE_URL . '/home.php');
            return;
        }

        $this->smarty->display('register.tpl');
    }

    public function registerExecute()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            try {
                $stmt = $this->pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
                $stmt->execute([$username, $password]);
                $message = "Регистрацията е успешна!";
                $this->smarty->assign('message', $message);
                $this->smarty->assign('user', $username);
                $_SESSION['username'] = $username;
                $this->redirect(BASE_URL . '/home.php');

            } catch (PDOException $e) {
                $message = "Грешка: " . $e->getMessage();
                $this->smarty->assign('message', $message);
                $this->redirect(BASE_URL . '/register.php');
            }

            
        }

        
    }
}
?>