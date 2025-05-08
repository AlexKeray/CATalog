<?php

// Alerts --------------------------------------------------------V
require_once BASE_PATH . '/misc/alerts.php';


// Smarty --------------------------------------------------------V
require_once BASE_PATH . '/vendor/autoload.php'; // За Smarty

use Smarty\Smarty;
$smarty = new Smarty();

$smarty->setTemplateDir(BASE_PATH . '/app/views');
$smarty->setCompileDir(BASE_PATH . '/storage/compiled');
$smarty->setCacheDir(BASE_PATH . '/storage/cache');
// --------------------------------------------------------^


// DB --------------------------------------------------------V
$host = 'localhost';
$db   = 'CATalog';
$user = 'root';
$pass = '12345';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // DSN - Data Source Name
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Ако стане грешка при заявка, PDO ще хвърли Exception.
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Когато използвам fetch, PDO ще връща асоциативен масив
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
// --------------------------------------------------------^


// Session --------------------------------------------------------V
session_start();
// --------------------------------------------------------^


// Router --------------------------------------------------------V
require_once BASE_PATH . '/core/router.php';

// Служи за пренасочване към правилния контролер.
$router = new Router($smarty, $pdo); 

// Взима /blog/post от http://localhost/blog/post?id=5&lang=bg
// $_SERVER['REQUEST_URI'] взима /blog/post?id=5&lang=bg от http://localhost/blog/post?id=5&lang=bg
// parse_url() взима само /blog/post от /blog/post?id=5&lang=bg
// URI е Uniform Resource Identifier което е всичко след https://localhost:8000/
$pageUri = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 8);

$router->direct($pageUri);
// --------------------------------------------------------^