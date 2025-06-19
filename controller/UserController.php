<?php
include_once __DIR__ . '/../model/UserModel.php';
include_once __DIR__ . '/../view/user/UserView.php';

class UserController
{
    public static function createAdminUser()
    {
        require_once __DIR__ . '/../model/UserModel.php';
        $userModel = new UserModel();
        UserModel::setConnection($GLOBALS['pdo']);

        $result = UserModel::registerAdmin('Admin', 'Super', 'admin123', 'admin');

        if ($result) {
            echo "✅ Admin created successfully";
        } else {
            echo "❌ Failed to create admin. The username may already be in use.";
        }
    }

    public static function handleRegister()
    {
        echo "<h1>Register</h1>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = trim($_POST['firstname'] ?? '');
            $lastname = trim($_POST['lastname'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($firstname === '' || $lastname === '' || $username === '' || $password === '') {
                echo "❌ All fields are required.";
                UserView::renderRegister();
                return;
            }

            $success = UserModel::register($firstname, $lastname, $password, $username);

            if ($success) {
                header("Location: public.php?page=login");
                exit;
            } else {
                echo "❌Registration failed. The username may already be in use.";
                UserView::renderRegister();
            }
        } else {
            UserView::renderRegister();
        }
    }

    public static function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username === '' || $password === '') {
                echo "❌ Username and password are required.";
                // UserView::renderLogin();
                return;
            }

            $user = UserModel::login($username, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();


                }

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];



                if ($user['role'] !== 'admin') {
                    header("Location: public.php?page=userDashboard ");
                } else {
                    header(
                        "Location: public.php?page=books"
                    );

                }
                exit;
            } else {
                echo "<p style='color:red;'>❌ اسم المستخدم أو كلمة المرور غير صحيحة.</p>";
                UserView::renderLogin();
            }
        } else {
            UserView::renderLogin();
        }
    }


   public static function logout()
{
    session_start();
    
    // حذف كل البيانات من الجلسة
    $_SESSION = [];

    // تدمير الجلسة
    session_destroy();

    // إعادة التوجيه للصفحة الرئيسية أو صفحة تسجيل الدخول
    header("Location: public.php?page=login");
    exit;
}


    public static function showAll()
    {
        $users = UserModel::getAllUsers();
        UserView::renderUserList($users);
    }

    public static function delete()
    {
        if (isset($_GET['del'])) {
            UserModel::deleteUser((int) $_GET['del']);
            header("Location: public.php?page=users");
            exit;
        }
    }
}
