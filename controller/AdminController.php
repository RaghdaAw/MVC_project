<?php
include_once __DIR__ . '/../model/dbConnect.php';
include_once __DIR__ . '/../model/Admin.php';

class AdminController {

    private $adminModel;

    public function __construct($pdo) {
        $this->adminModel = new Admin($pdo);
    }

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $admin_username = $_POST['admin_username'] ?? '';
            $admin_password = $_POST['admin_password'] ?? '';

            $admin = $this->adminModel->login($admin_username, $admin_password);
            if ($admin) {
                session_start();
                $_SESSION['admin'] = $admin;
                header("location: view/index.php");
                exit();
            } else {
                include __DIR__ . '/../view/login.php';
            }
        }
    }

    public function showAdmins()
    {
        $admins = $this->adminModel->getAllAdmins();
        // include '../view/index.php';
        header("location: ../view/index.php");
        exit();
    }
}

$adminController = new AdminController($pdo);
if (isset($_GET['page']) && $_GET['page'] === $admins) {
    // include_once '../model/dbConnect.php';
    $adminController->showAdmins();
}
