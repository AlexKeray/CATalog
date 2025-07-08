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

                $this->setAlert(Alert::RegistrationSuccess, AlertType::Success);

                $_SESSION['username'] = $username;

                $this->redirect(BASE_URL . '/login.php');

            } catch (PDOException $e) {

                $this->setAlert(Alert::UsernameTaken, AlertType::Error);

                //$this->printException($e);

                $this->redirect(BASE_URL . '/register.php');
            }

            
        }

        
    }
}
?>