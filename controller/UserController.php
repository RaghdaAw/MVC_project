<?php
include_once __DIR__ . '/../model/UserModel.php';
include_once __DIR__ . '/../view/user/UserView.php';

class UserController
{
    public static function createAdminUser()
    {
        UserModel::setConnection($GLOBALS['pdo']);
        
        // تحقق إن الأدمن موجود سابقاً لتفادي التكرار
        $existingAdmins = array_filter(UserModel::getAllUsers(), function($user) {
            return $user->role === 'admin';
        });
        if (count($existingAdmins) > 0) {
            echo "❌ Admin user already exists.";
            return;
        }

        $user = new UserModel();
        $user->firstname = 'Admin';
        $user->lastname = 'Super';
        $user->username = 'admin';
        $user->password = 'admin123'; // سيتم تشفيرها في save()
        $user->role = 'admin';

        try {
            $user->save();
            echo "✅ Admin created successfully";
        } catch (Exception $e) {
            echo "❌ Failed to create admin. Possibly username already exists.";
        }
    }

    public static function handleRegister()
    {
        UserModel::setConnection($GLOBALS['pdo']);

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

            // username validation
            $allUsers = UserModel::getAllUsers();
            foreach ($allUsers as $existingUser) {
                if ($existingUser->username === $username) {
                    echo "❌ Username already in use.";
                    UserView::renderRegister();
                    return;
                }
            }

            $user = new UserModel();
            $user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->username = $username;
            $user->password = $password; 
            $user->role = 'user';

            try {
                $user->save();
                header("Location: public.php?page=login");
                exit;
            } catch (Exception $e) {
                echo "❌ Registration failed.";
                UserView::renderRegister();
            }
        } else {
            UserView::renderRegister();
        }
    }

    public static function handleLogin()
    {
        UserModel::setConnection($GLOBALS['pdo']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username === '' || $password === '') {
                echo "❌ Username and password are required.";
                UserView::renderLogin();
                return;
            }

            $user = UserModel::login($username, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['user_id'] = $user->getID();
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role;

                if ($user->role !== 'admin') {
                    header("Location: public.php?page=userDashboard");
                } else {
                    header("Location: public.php?page=books");
                }
                exit;
            } else {
                echo "<p style='color:red;'>❌ UserName of Passwoord fout.</p>";
                UserView::renderLogin();
            }
        } else {
            UserView::renderLogin();
        }
    }

    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
     // delete session data
        $_SESSION = [];
        session_destroy();

        header("Location: public.php?page=login");
        exit;
    }

    public static function showAll()
    {
        UserModel::setConnection($GLOBALS['pdo']);

        $users = UserModel::getAllUsers();
        UserView::renderUserList($users);
    }

    public static function delete()
    {
        UserModel::setConnection($GLOBALS['pdo']);

        if (isset($_GET['del'])) {
            $user = UserModel::load((int)$_GET['del']);
            if ($user) {
                $user->delete();
            }
            header("Location: public.php?page=users");
            exit;
        }
    }
}
