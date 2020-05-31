<?php

use MgmtUi\Controllers\HomeController;
use MgmtUi\Controllers\DockerController;

require_once 'vendor/autoload.php';

$router = new \Klein\Klein();

$router->respond('GET', '/', HomeController::route('home'));
$router->respond('GET', '/test', DockerController::route('test'));
$router->respond('POST', '/image/[:imageId]/create-container', DockerController::route('createContainer'));
$router->respond('POST', '/container/[:containerId]/delete', DockerController::route('deleteContainer'));
$router->respond('POST', '/container/[:containerId]/start', DockerController::route('startContainer'));
$router->respond('POST', '/container/[:containerId]/stop', DockerController::route('stopContainer'));
$router->respond('POST', '/container/[:containerId]/restart', DockerController::route('restartContainer'));

$router->dispatch();
