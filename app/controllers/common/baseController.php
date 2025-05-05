<?php
class BaseController
{
    protected $smarty;
    protected $pdo;
    protected $user;

    public function __construct($smarty, $pdo = null)
    {
        $this->smarty = $smarty;
        $this->pdo = $pdo;

        $this->smarty->assign('base_path', BASE_PATH);
    }

    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit; // гарантира, че кодът след реда с header() няма да се изпълни нищо друго
    }

    protected function assignUser() // извлича потребителя от сесията и го присвоява на полето $user на този контролер (родителския на останалите)
    {
        $this->user = $_SESSION['username'] ?? null;
        $this->smarty->assign('user', $this->user);
    }
}
?>