<?php
require_once 'model/dbConnect.php';
require_once 'controller/UserController.php';
require_once 'controller/HomeController.php';

$userController = new UserController($pdo);
$homeController = new HomeController();

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'register':
            $userController->register();
            // $homeController->home();

            break;
        case 'login':
            $userController->login();
            // $homeController->home();

            break;
        case 'logout':
            $userController->logout();
            break;
        case 'users':
            $userController->showAllUsers();
            break;
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
}
