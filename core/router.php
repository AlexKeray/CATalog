<?php

class Router {
    private $smarty;

    public function __construct($smarty, $pdo) {
        $this->smarty = $smarty;
        $this->pdo = $pdo;
    }

    // uri е Uniform Resource Identifier което е всичко след https://localhost:8000/
    // pageUri е всичко след https://localhost:8000/CATalog/
    public function direct($pageUri) { 
        switch ($pageUri) {
            case '/':
            case '/index.php':
            case '/home.php':
                require BASE_PATH . '/app/controllers/homeController.php';
                $controller = new HomeController($this->smarty, $this->pdo);
                $controller->homeShow();
                break;
            case '/register.php':
                require BASE_PATH . '/app/controllers/registerController.php';
                $controller = new RegisterController($this->smarty, $this->pdo);

                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $controller->registerShow();
                }
                else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->registerExecute();
                }
                else {
                    http_response_code(405);
                    echo "Страницата не съществува.";
                }
                break;
            case '/login.php':
                require BASE_PATH . '/app/controllers/loginController.php';
                $controller = new LoginController($this->smarty, $this->pdo);

                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $controller->loginShow();
                }
                else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->loginExecute();
                }
                else {
                    http_response_code(405);
                    echo "Страницата не съществува.";
                }
                break;
            case '/logout.php':
                require BASE_PATH . '/app/controllers/logoutController.php';
                $controller = new LogoutController($this->smarty);

                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $controller->logoutExecute();
                }
                else {
                    http_response_code(405);
                    echo "Страницата не съществува.";
                }
                break;
            default:
                http_response_code(404);
                echo "Страницата не съществува.";
        }
    }
}

?>