<?php

namespace Asifmuztaba\UserManagement\Models;

use Asifmuztaba\UserManagement\Managers\DatabaseManager;

class User
{
    private DatabaseManager $db;

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    public function create($username, $email, $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $this->db->insert('users', [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
        ]);
    }

    public function findByEmail($email)
    {
        // Fetch user record from the database
        $result = $this->db->select('users', ['email' => $email]);

        if ($result) {
            return $result[0]; // Return the first (and hopefully only) user found
        } else {
            return false;
        }
    }

    public function roles(): false|array
    {
        $sql = "SELECT roles.* FROM roles 
                JOIN role_user ON roles.id = role_user.role_id
                WHERE role_user.user_id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll();
    }

    public function assignRole($roleId): bool
    {
        return $this->db->insert('role_user', [
            'user_id' => $this->id,
            'role_id' => $roleId,
        ]);
    }

    public function removeRole($roleId): bool
    {
        return $this->db->delete('role_user', [
            'user_id' => $this->id,
            'role_id' => $roleId,
        ]);
    }
}
