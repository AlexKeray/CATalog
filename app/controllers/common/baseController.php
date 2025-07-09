<?php
class BaseController
{
    protected $smarty;
    protected $pdo;
    protected $user = [];

    public function __construct($smarty, $pdo = null)
    {
        $this->smarty = $smarty;
        $this->pdo = $pdo;

        $this->smarty->assign('base_path', BASE_PATH);
        $this->smarty->assign('base_url', BASE_URL);

        $this->assignUser();

        $this->loadAlert(); // зарежда alert-а от сесията в смартито
    }

    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit; // гарантира, че кодът след реда с header() няма да се изпълни нищо друго
    }

    protected function assignUser() // извлича потребителя от сесията и го присвоява на полето $user на този контролер (родителския на останалите)
    {   
        $this->user = [
            'id' => $_SESSION['user']['id'] ?? null,
            'username' => $_SESSION['user']['username'] ?? null
        ];

        $this->smarty->assign('user', $this->user);
    }

    protected function authorise()
    {
        if (!isset($this->user['id'])) {
            $this->redirect(BASE_URL . '/login.php');
        }
    }

    // метод за задаване на съобщение в сесията
    // типът на съобщението може да бъде 'message', 'success' 'error' или 'warning'
    // методът работи заедно с метода loadAlert() който зарежда съобщението от сесията в смартито
    // това е така за да може да се предават съобщения през редиректи
    public function setAlert(Alert $text, AlertType $type = AlertType::Message)
    {
        $allowedTypes = [AlertType::Message, AlertType::Success, AlertType::Warning, AlertType::Error];
        //$allowedTypes = ['message', 'success' 'error', 'warning'];

    
        if (!in_array($type, $allowedTypes)) {
            throw new InvalidArgumentException("Невалиден тип за alert: " . htmlspecialchars($type));
        }
    
        $_SESSION[$type->value] = $text->value;

        $this->smarty->assign($type->value, $text->value);
    }
    
    private function loadAlert()
    {
        foreach ([AlertType::Message, AlertType::Success, AlertType::Warning, AlertType::Error] as $alertType) {
            if (isset($_SESSION[$alertType->value])) {
                $this->smarty->assign($alertType->value, $_SESSION[$alertType->value]);
                unset($_SESSION[$alertType->value]);
            }
        }
    }

    protected function printException(Throwable $e)
    {
        // 1. Показваш грешката на екрана (за разработка)
        echo '<pre>';
        echo "Грешка: " . htmlspecialchars($e->getMessage()) . "\n\n";
        echo "Файл: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
        echo "Stack trace:\n" . $e->getTraceAsString();
        echo '</pre>';
        exit;
    }

    protected function debug($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }

    protected function nullIfEmpty($value)
    {
        return $value === '' ? null : $value;
    }

}
?>