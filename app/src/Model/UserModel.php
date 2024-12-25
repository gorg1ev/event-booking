<?php

namespace App\Model;

use App\Enum\UserRole;
use App\Model;
use PDO;

class UserModel extends Model
{
    public function registerUser(string $fullName, string $email, string $password)
    {
        try {

            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO users (full_name, email, pwd)
                            VALUES (:fullName, :email, :password)");

            $stmt->bindValue(':fullName', $fullName);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':password', $password);

            $stmt->execute();

            $userId = (int)$this->db->lastInsertId();

            $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role_id)
                                    VALUES (:user_id, :role_id)");

            $stmt->bindValue(':user_id', $userId);
            $stmt->bindValue(':role_id', UserRole::USER->value);

            $stmt->execute();

            $this->db->commit();
        } catch (\PDOException) {
            $this->db->rollback();
        }

    }

    public function findUserByEmail(string $email)
    {
        $stmt = $this->db->prepare("SELECT id, full_name, email, pwd, avatar FROM users
                                    WHERE email = :email");

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch();

        return $user;
    }

    public function getUserRoles(int $id)
    {
        $stmt = $this->db->prepare("SELECT role_id FROM user_roles
                                    WHERE user_id = :user_id");

        $stmt->bindParam(':user_id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    public function findUserById(int $id): array
    {
        $stmt = $this->db->prepare("SELECT id, full_name, email FROM users
                                    WHERE id = :id");

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function updateUser(string $fullName, string $password, string $avatarPath)
    {
        $id = $_SESSION['user']['id'];

        $updated = [];
        $params = [];

        if (!empty($fullName)) {
            $updated[] = 'full_name = :fullName';
            $params[':fullName'] = $fullName;
        }
        if (!empty($password)) {
            $updated[] = 'pwd = :password';
            $params[':password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        if (!empty($avatarPath)) {
            $updated[] = 'avatar = :avatar';
            $params[':avatar'] = $avatarPath;
        }

        $sql = 'UPDATE users SET ' . implode(', ', $updated) . ' WHERE id = :id';
        $params[':id'] = $id;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
    }
}