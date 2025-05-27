<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function register($firstname, $lastname, $password, $username)
{
    try {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (firstname, lastname, password, username) 
                                     VALUES (:firstname, :lastname, :password, :username)");
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':password' => $hashedPassword,
            ':username' => $username
        ]);
        echo "✅ User registered successfully!<br>";
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "❌ Database error: " . $e->getMessage();
        return false;
    }
}


    public function login($username, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
