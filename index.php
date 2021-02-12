<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router('localhost:8082');

$router->namespace("App\Controller");
$router->group(null);
$router->get('/home', "HomeController:index", 'home.index');
$router->get('/suporte', "HomeController:suporte", 'home.suporte');
$router->get('/craw', 'HomeController:crawling', 'home.crawling');

$router->group("error");
$router->get("/{errcode}", "HomeController:error");

$router->dispatch();

if ($router->error()) {
    $errorCode = $router->error();
    Header("Location: /error/{$errorCode}");
}


