<?php
require_once 'model/dbConnect.php';
require_once 'controller/UserController.php';
<<<<<<< HEAD
require_once 'controller/HomeController.php';

$userController = new UserController($pdo);
$homeController = new HomeController();
=======
require_once 'controller/HomeController.php'; 

$userController = new UserController($pdo);
$homeController = new HomeController(); 
>>>>>>> origin/test_admin

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'register':
            $userController->register();
<<<<<<< HEAD
            // $homeController->home();

            break;
        case 'login':
            $userController->login();
            // $homeController->home();

=======
            break;
        case 'login':
            $userController->login();
>>>>>>> origin/test_admin
            break;
        case 'logout':
            $userController->logout();
            break;
        case 'users':
            $userController->showAllUsers();
            break;
<<<<<<< HEAD
        case 'home':
            $homeController->home();
            break;
        default:
            // $userController->register();
            $homeController->home();
            break;
=======
        case 'home': 
            $homeController->home();
            break;
        default:
            $homeController->home(); 
>>>>>>> origin/test_admin
    }
} elseif (isset($_GET['del'])) {
    $userController->deleteUser();
} else {
<<<<<<< HEAD
    $homeController->home();
=======
    $homeController->home();  
>>>>>>> origin/test_admin
}
