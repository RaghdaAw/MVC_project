<?php

class Admin {

    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function login($admin_username, $admin_password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM adminlogin WHERE admin_username = :admin_username");
        $stmt->execute(['admin_username' => $admin_username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($admin_password, $admin['admin_password'])) {
            return $admin;
        }
        return false;
    }

    public function getAllAdmins(){
        $stmt = $this->pdo->prepare("SELECT * FROM adminlogin");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}