<?php

require_once BASE_PATH . '/vendor/autoload.php'; // За Smarty

use Smarty\Smarty;
$smarty = new Smarty();

$smarty->setTemplateDir(BASE_PATH . '/app/views');
$smarty->setCompileDir(BASE_PATH . '/storage/compiled');
$smarty->setCacheDir(BASE_PATH . '/storage/cache');

require_once BASE_PATH . '/core/router.php';

// Служи за пренасочване към правилния контролер.
// Ако имаме Smarty трябва да му подадем неговата инстанция на контролера
$router = new Router($smarty); 

// Взима /blog/post от http://localhost/blog/post?id=5&lang=bg
// $_SERVER['REQUEST_URI'] взима /blog/post?id=5&lang=bg от http://localhost/blog/post?id=5&lang=bg
// parse_url() взима само /blog/post от /blog/post?id=5&lang=bg
// URI е Uniform Resource Identifier което е всичко след https://localhost:8000/
$uri = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), 8);

$router->direct($uri);