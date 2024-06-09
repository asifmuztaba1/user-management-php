<?php

namespace Asifmuztaba\UserManagement\Controllers;

use Asifmuztaba\UserManagement\Managers\ContainerManager;
use Asifmuztaba\UserManagement\Models\Role;
use Asifmuztaba\UserManagement\Models\User;

class RegistrationController
{
    private User $user;

    public function __construct(ContainerManager $container)
    {
        $this->user = $container->resolve(User::class);
    }

    public function showRegistrationForm(): void
    {
        require_once __DIR__ . '/../Views/register.php';
    }

    public function register(): void
    {
        // Validate input
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password_confirmation = $_POST['password_confirmation'] ?? '';

        // Basic validation
        if (!$username || !$email || !$password || !$password_confirmation) {
            // Handle validation errors
            echo "All fields are required.";
            return;
        }

        if ($password !== $password_confirmation) {
            echo "Password confirmation does not match.";
            return;
        }

        // Check if the email already exists
        $existingUser = $this->user->findByEmail($email);
        if ($existingUser) {
            echo "Email already exists. Please use a different email.";
            return;
        }
        // Assign default role (adjust as needed)
        $role = Role::findByName('user'); // Assuming 'user' is a default role
        if (!$role) {
            echo "Default role not found.";
            return;
        }
        // Create the user
        $userId = $this->user->create($username, $email, $password);

        if ($userId) {
            require_once __DIR__ . '/../Views/dashboard.php';
        } else {
            echo "Registration failed.";
        }
    }
}
