<?php
session_start();

include_once __DIR__ . '/model/dbConnect.php';
include_once __DIR__ . '/controller/UserController.php';
include_once __DIR__ . '/controller/BookController.php';
include_once __DIR__ . '/controller/CartController.php';
include_once __DIR__ . '/controller/LikeController.php';
include_once __DIR__ . '/controller/ContactController.php';


include_once __DIR__ . '/model/UserModel.php';
include_once __DIR__ . '/model/CartModel.php';
include_once __DIR__ . '/model/LikeModel.php';

global $pdo;

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
        if (!isset($_SESSION['role'])) {
            // Visitor
          
            BookController::showUserBooks();
        } elseif ($_SESSION['role'] === 'user') {
        
            // User 
            $books = Book::findAll();
            BookController::showUserBooks();
        } else {

            echo "⛔ Access Denied";
        }
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
        CartController::execute();
        break;

    case 'removeFromCart':
        if (!isset($_GET['cart_id'])) {
            echo "❌ Missing cart_id.";
            exit;
        }


        $cart_id = $_GET['cart_id'];
        CartModel::decreaseOrDelete($cart_id);


        header("Location: public.php?page=cart");
        exit;

    // ✅ Like
    case 'likeBook':
        LikeController::likeBook();
        break;

    case 'like':
        LikeController::showLike();
        break;

    case 'removeFromLike':
        LikeController::delete();
        break;

    case 'contact':
        ContactController::show();
        break;

    // ✅ Search
    case 'search':
        BookController::search();
        break;

    default:
        echo "<h1>Welcome</h1>
              <a href='?page=login'>Login</a> | 
              <a href='?page=register'>Register</a>";
        break;
}
?>

<script src="view/assets/js/main.js"></script>
<link rel="stylesheet" href="view/assets/css/main.css" />
<link rel="stylesheet" href="view/assets/css/about.css" />