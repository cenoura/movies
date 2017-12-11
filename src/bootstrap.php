<?php

use Cenoura\Movie\MovieProvider;
use Cenoura\Support\Application;

require __DIR__ . '/autoload.php';

$app = new Application();
$app->loadConfigFiles(__DIR__ . '/../config');

$movieProvider = new MovieProvider();
$app->register($movieProvider);

try {
    $controller = $app->getController();
    $action = $app->getAction();

    $controller->$action();
} catch (\Exception $e) {
    echo 'Controller and/or Action not found.';
}