<?php

namespace Asifmuztaba\UserManagement\Routes;

class Web
{
    public function handle()
    {
        session_start();

        $uri = trim($_SERVER['REQUEST_URI'], '/');
        $method = $_SERVER['REQUEST_METHOD'];


        switch ($uri) {
            case '':
                http_response_code(200);
                echo "Hello world";
                break;
            default:
                http_response_code(404);
                echo "404 Not Found";
                break;
        }
    }
}
