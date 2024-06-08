<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Adjust the path to autoload.php as necessary

use Asifmuztaba\UserManagement\Routes\Web;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');
$router = new Web();
$router->handle();