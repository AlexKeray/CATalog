<?php

class HomeController {

    private $smarty;

    public function __construct($smarty) {
        $this->smarty = $smarty;
    }

    public function index() {
        $this->smarty->assign('user', 'Алекс');
        $this->smarty->display('home.tpl');
    }
}

?>