<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Adjust the path to autoload.php as necessary

use Asifmuztaba\UserManagement\Managers\ContainerManager;
use Asifmuztaba\UserManagement\Managers\DatabaseManager;
use Asifmuztaba\UserManagement\Models\User;
use Asifmuztaba\UserManagement\Routes\Web;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');
$container = new ContainerManager();

$container->singleton(DatabaseManager::class, function () {
    return new DatabaseManager();
});

$container->bind(User::class, function ($container) {
    return new User($container->resolve(DatabaseManager::class));
});

$router = new Web($container);
$router->handle();
