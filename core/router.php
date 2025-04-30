<?php

class Router {
    private $smarty;

    public function __construct($smarty) {
        $this->smarty = $smarty;
    }

    public function direct($uri) { // uri е Uniform Resource Identifier което е всичко след https://localhost:8000/
        switch ($uri) {
            case '/':
            case '/index.php':
                require BASE_PATH . '/app/controllers/homeController.php';
                $controller = new HomeController($this->smarty); // подаваме smarty
                $controller->index();
                break;
            default:
                http_response_code(404);
                echo "Страницата не съществува.";
        }
    }
}

?>