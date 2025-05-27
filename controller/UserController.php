<?php
include_once 'model/User.php';
session_start();

class UserController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $password = $_POST['password'];
            $username = $_POST['username'];

            if ($this->userModel->register($firstname, $lastname, $password,$username)) {
                header("Location: view/login.php");
                echo "✅ User registered successfully.";
                exit;
            } else {
                echo "❌ error registering user. Please try again.";
            }
        }
        include '../view/register.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                header("Location: ../view/index.php");
                exit;
            } else {
                echo "❌ username or passwor is fout.";
            }
        }
        include '../view/login.php';
    }

    public function logout()
    {
        session_destroy();
        header("Location: ../view/login.php");
        exit;
    }
}
