<?php

use MgmtUi\Controllers\HomeController;
use MgmtUi\Controllers\DockerController;

require_once 'vendor/autoload.php';

$router = new \Klein\Klein();

$router->respond('GET', '/', HomeController::call('home'));
$router->respond('GET', '/test', DockerController::call('test'));


$router->dispatch();
