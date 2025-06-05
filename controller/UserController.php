<?php
// include_once '../model/dbConnect.php';
include_once __DIR__ . '/../model/dbConnect.php';
include_once __DIR__ . '/../model/User.php';
class UserController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }
    public function register()
    {
<<<<<<< HEAD

=======
>>>>>>> test_admin
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
<<<<<<< HEAD
            echo "test raghda";

            if ($this->userModel->register($firstname, $lastname, $password, $username)) {
                // echo "✅ User registered successfully!";
                header("Location: view/login.php"); // ✅ إعادة التوجيه بعد التسجيل
                exit;


=======

            if ($this->userModel->register($firstname, $lastname, $password, $username)) {
                echo "✅ User registered successfully!";
           header("Location: view/login.php");

            exit;
>>>>>>> test_admin
            } else {
                echo "❌ Failed to register user.";
            }
        } else {
<<<<<<< HEAD

            //    header("Location: view/register.php");
            exit;
        }

=======
            // استعرض الفورم إن لم يكن POST
           header("Location: view/register.php");
            exit;
        }
>>>>>>> test_admin
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($username, $password);
            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                header("Location: view/index.php");
                exit;
            } else {
                echo "❌ Invalid username or password.";
            }
        } else {
            // استعرض الفورم إن لم يكن POST
<<<<<<< HEAD
            // include __DIR__ . 'view/login.php';
=======
            include __DIR__ . 'view/login.php';
>>>>>>> test_admin
        }
    }
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: view/login.php");
        exit;
    }
    public function showAllUsers()
    {
        $users = $this->userModel->getAllusers();
        // include '../view/index.php';
        header("Location: ../view/index.php");
        exit;
    }

    public function deleteUser()
    {
        if (isset($_GET['del'])) {
            $id = intval($_GET['del']);
            $this->userModel->deleteUser($id);
            header("Location: ../view/index.php");
            exit;
        }
    }
}

<<<<<<< HEAD
// معالجة الطلب مباشرة من الرابط
=======


$controller = new UserController($pdo);

if (isset($_GET['page']) && $_GET['page'] === 'users') {
    // include_once '../model/dbConnect.php';
    $controller->showAllUsers();
} elseif (isset($_GET['del'])) {
    $controller->deleteUser();
}
>>>>>>> test_admin

$controller = new UserController($pdo);

if (isset($_GET['page']) && $_GET['page'] === 'users') {
    // include_once '../model/dbConnect.php';
    $controller->showAllUsers();
} elseif (isset($_GET['del'])) {
    $controller->deleteUser();
}

