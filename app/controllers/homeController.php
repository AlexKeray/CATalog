<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class HomeController extends BaseController {

    public function __construct($smarty, $pdo)
    {
        parent::__construct($smarty, $pdo);
    }

    public function homeShow() 
    {
        $this->assignUser();
        $this->smarty->display('home.tpl');
    }
}

?>