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

        session_start();

        $this->setAlert(Alert::LogoutSuccess, AlertType::Success);

        $this->redirect(BASE_URL . '/login.php');
    }
}
?>