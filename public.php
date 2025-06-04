<?php
require_once 'model/dbConnect.php';
require_once 'controller/UserController.php';
require_once 'controller/HomeController.php'; 

$userController = new UserController($pdo);


if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'register':
            $userController->register();
            break;
        case 'login':
            $userController->login();
            break;
        case 'logout':
            $userController->logout();
            break;
        case 'users':
            $userController->showAllUsers();
            break;
        
    }
} elseif (isset($_GET['del'])) {
    $userController->deleteUser();
} 
