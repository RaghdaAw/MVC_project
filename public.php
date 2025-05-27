<?php
require_once 'controller/UserController.php';
require_once 'model/dbConnect.php';

$controller = new UserController($pdo);

$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'register':
        $controller->register();
        break;
    case 'login':
        $controller->login();
        break;
    case 'logout':
        $controller->logout();
        break;
    default:
        echo "الصفحة غير موجودة.";
        break;
}
