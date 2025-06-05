<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // ✳️ تسجيل مستخدم عادي
    public function register($firstname, $lastname, $password, $username)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("
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
            echo "❌ Database error: " . $e->getMessage();
            return false;
        }
    }

    // ✅ تسجيل الأدمن (مرة واحدة)
    public function registerAdmin($firstname, $lastname, $password, $username)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("
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
            echo "❌ Database error: " . $e->getMessage();
            return false;
        }
    }

    // 🔐 تسجيل الدخول
    public function login($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // يحتوي على role ويمكن التحقق منه لاحقًا
        }

        return false;
    }

    // 📋 إحضار كل المستخدمين
    public function getAllUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ❌ حذف مستخدم
    public function deleteUser($user_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
