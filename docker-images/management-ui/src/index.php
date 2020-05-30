<?php

use MgmtUi\Controllers\Home as HomeController;
use MgmtUi\Controllers\Docker as DockerController;

require_once 'vendor/autoload.php';

$router = new \Klein\Klein();

$router->respond('GET', '/', [HomeController::class, 'home']);
$router->respond('GET', '/test', [DockerController::class, 'test']);


$router->dispatch();
