<?php
require_once 'model/dbConnect.php';
require_once 'controller/UserController.php';
<<<<<<< HEAD
require_once 'controller/HomeController.php';

$userController = new UserController($pdo);
$homeController = new HomeController();
=======
require_once 'controller/BookController.php';

// require_once 'controller/HomeController.php';

$userController = new UserController($pdo);
$bookController = new BookController($pdo);
>>>>>>> test_admin

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
>>>>>>> test_admin
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
    }
} elseif (isset($_GET['del'])) {
    $userController->deleteUser();
} else {
    $homeController->home();
=======
        // case 'updateBook':
        //     $bookController->updateBook(); 
        //     break;
    }
} elseif (isset($_GET['del'])) {
    $userController->deleteUser();
>>>>>>> test_admin
}
