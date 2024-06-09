<?php

namespace Asifmuztaba\UserManagement\Routes;

use Asifmuztaba\UserManagement\Controllers\RegistrationController;
use Asifmuztaba\UserManagement\Managers\ContainerManager;

class Web
{
    private ContainerManager $container;

    public function __construct(ContainerManager $container)
    {
        $this->container = $container;
    }

    public function handle()
    {
        session_start();

        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $method = $_SERVER['REQUEST_METHOD'];


        switch ($uri) {
            case '':
                require_once __DIR__ . '/../Views/dashboard.php';
                break;
            case 'login':
                require_once __DIR__ . '/../Views/login.php';
                break;
            case 'register':
                $registrationController = new RegistrationController($this->container);
                if ($method === 'POST') {
                    $registrationController->register();
                } else {
                    $registrationController->showRegistrationForm();
                }
                break;
            default:
                http_response_code(404);
                echo "404 Not Found";
                break;
        }
    }
}
