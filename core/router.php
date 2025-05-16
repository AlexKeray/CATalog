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
            case '/upload.php':
                require BASE_PATH . '/app/controllers/mediaController.php';
                $controller = new MediaController($this->smarty, $this->pdo);

                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $controller->personalMediaShow();
                }
                else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->uploadExecute();
                }
                else {
                    http_response_code(405);
                    echo "Страницата не съществува.";
                }
                break;
            case '/personal-media.php':
                require_once BASE_PATH . '/app/controllers/mediaController.php';
                $controller = new MediaController($this->smarty, $this->pdo);

                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $controller->personalMediaShow();
                }
                else {
                    http_response_code(405);
                    echo "Страницата не съществува.";
                }
                break;
            case '/delete.php':
                require BASE_PATH . '/app/controllers/deleteController.php';
                $controller = new DeleteController($this->smarty, $this->pdo);

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->deleteExecute();
                }
                else {
                    http_response_code(405);
                    echo "Страницата не съществува.";
                }
                break;
            case '/search.php':
                require BASE_PATH . '/app/controllers/searchController.php';
                $controller = new SearchController($this->smarty, $this->pdo);
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $controller->searchExecute();
                }
                else {
                    http_response_code(405);
                    echo "Страницата не съществува.";
                }
                break;
            case '/searchAjax':
                require BASE_PATH . '/app/controllers/searchController.php';
                $controller = new SearchController($this->smarty, $this->pdo);
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $controller->searchAjaxExecute();
                }
                else {
                    http_response_code(405);
                }
                break;
            case '/exportExcel':
                require BASE_PATH . '/app/controllers/exportExcelController.php';
                $controller = new ExportExcelController($this->smarty, $this->pdo);
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $controller->exportExecute();
                }
                else {
                    http_response_code(405);
                    echo "Страницата не съществува.";
                }
                break;
            case (preg_match('#^/edit/(\d+)$#', $pageUri, $matches) ? true : false):
                require BASE_PATH . '/app/controllers/mediaController.php';
                $controller = new MediaController($this->smarty, $this->pdo);
                $controller->editShow((int)$matches[1]);
                break;

            case '/edit.php':
                require BASE_PATH . '/app/controllers/mediaController.php';
                $controller = new MediaController($this->smarty, $this->pdo);
                $controller->editExecute();
                break;
            default:
                http_response_code(404);
                echo "Страницата не съществува.";
        }
    }
}

?>