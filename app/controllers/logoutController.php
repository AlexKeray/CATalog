<?php

require_once BASE_PATH . '/app/controllers/common/BaseController.php';

class LogoutController extends BaseController
{
    public function __construct($smarty)
    {
        parent::__construct($smarty);
    }

    public function logoutExecute()
    {

        $_SESSION = [];

        session_destroy();

        $this->redirect(BASE_URL . '/login.php');
    }
}
?>