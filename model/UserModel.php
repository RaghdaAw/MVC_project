<?php

class UserModel
{
    private static $pdo;

    public static function setConnection($pdo)
    {
        self::$pdo = $pdo;
    }
    public static function registerAdmin($firstname, $lastname, $password, $username)
    {
        try {
            $stmt = self::$pdo->prepare("SELECT user_id FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);

            if ($stmt->fetch()) {
                return false;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = self::$pdo->prepare("
            INSERT INTO users (firstname, lastname, password, username, role)
            VALUES (:firstname, :lastname, :password, :username, 'admin')
        ");
            $stmt->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':password' => $hashedPassword,
                ':username' => $username
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function register($firstname, $lastname, $password, $username)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = self::$pdo->prepare("
                INSERT INTO users (firstname, lastname, password, username, role)
                VALUES (:firstname, :lastname, :password, :username, 'user')
            ");
            $stmt->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':password' => $hashedPassword,
                ':username' => $username
            ]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function login($username, $password)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public static function getAllUsers()
    {
        $stmt = self::$pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteUser($id)
    {
        $stmt = self::$pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        return $stmt->execute([':user_id' => $id]);
    }
}
