<?php
session_start();

include_once __DIR__ . '/model/dbConnect.php';
include_once __DIR__ . '/controller/UserController.php';
include_once __DIR__ . '/controller/BookController.php';
include_once __DIR__ . '/controller/CartController.php';

UserModel::setConnection($pdo);
CartModel::setConnection($pdo);

$page = $_GET['page'] ?? '';

switch ($page) {
    case 'register':
        UserController::handleRegister();
        break;

    case 'login':
        UserController::handleLogin();
        break;

    case 'logout':
        UserController::logout();
        break;

    case 'books':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo "⛔ Access Denied";
            exit;
        }
        BookController::showAll();
        break;

    case 'addBook':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo "⛔ Access Denied";
            exit;
        }
        BookController::add();
        break;

    case 'deleteBook':
        BookController::delete();
        break;

    case 'editBook':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo "⛔ Access Denied";
            exit;
        }
        BookController::edit();
        break;

    case 'updateBook':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            echo "⛔ Access Denied";
            exit;
        }
        BookController::update();
        break;

    case 'userDashboard':
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
            echo "⛔ Access Denied";
            exit;
        }
        BookController::showUserBooks();
        break;

    case 'users':
        UserController::showAll();
        break;

    case 'delete':
        UserController::delete();
        break;

    // ✅ Cart
    case 'addToCart':
        CartController::addToCart();
        break;

    case 'cart':
        CartController::showCart();
        break;
    case 'removeFromCart':
        CartController::delete();
        break;


    default:
        echo "<h1>Welcome</h1>
              <a href='?page=login'>Login</a> | 
              <a href='?page=register'>Register</a>";
        break;
}
