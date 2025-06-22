<?php

class UserModel
{
    private static $pdo;

    private $id;
    public $firstname;
    public $lastname;
    public $username;
    public $password; // raw password, for insert only
    public $role;

    public function __construct()
    {
        $this->firstname = "";
        $this->lastname = "";
        $this->username = "";
        $this->password = "";
        $this->role = "user";
        $this->id = null;
    }

    public static function setConnection($pdo)
    {
        self::$pdo = $pdo;
    }

    public static function initializeDatabase()
    {
        $stmt = self::$pdo->prepare("
            CREATE TABLE IF NOT EXISTS users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(100) NOT NULL,
                lastname VARCHAR(100) NOT NULL,
                username VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL
            );
        ");
        $stmt->execute();
    }

    public function getID()
    {
        return $this->id;
    }

    public function save()
    {
        if ($this->id !== null) {
            // Update
            $stmt = self::$pdo->prepare("
                UPDATE users 
                SET firstname = :firstname, lastname = :lastname, username = :username, role = :role
                WHERE user_id = :id
            ");
            $stmt->execute([
                ':firstname' => $this->firstname,
                ':lastname' => $this->lastname,
                ':username' => $this->username,
                ':role' => $this->role,
                ':id' => $this->id
            ]);
        } else {
            // Insert
            $stmt = self::$pdo->prepare("
                INSERT INTO users (firstname, lastname, username, password, role)
                VALUES (:firstname, :lastname, :username, :password, :role)
            ");
            $stmt->execute([
                ':firstname' => $this->firstname,
                ':lastname' => $this->lastname,
                ':username' => $this->username,
                ':password' => password_hash($this->password, PASSWORD_DEFAULT),
                ':role' => $this->role
            ]);
            $this->id = self::$pdo->lastInsertId();
        }
    }

    public function delete()
    {
        if ($this->id === null) {
            throw new Exception("User not found.");
        }
        $stmt = self::$pdo->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute([':id' => $this->id]);
        $this->id = null;
    }

    public static function load($id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE user_id = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return self::loadFromRow($data);
    }

    public static function loadFromRow($data)
    {
        $user = new UserModel();
        $user->id = $data['user_id'];
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->username = $data['username'];
        $user->password = ''; // لا نسترجع كلمة السر المشفرة
        $user->role = $data['role'];
        return $user;
    }

    public static function getAllUsers()
    {
        $stmt = self::$pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'loadFromRow'], $rows);
    }

    public static function login($username, $password)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password'])) {
            return self::loadFromRow($userData);
        }
        return false;
    }
}
