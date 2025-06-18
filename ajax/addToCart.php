<?php
session_start();
require_once __DIR__ . '/../model/dbConnect.php';
require_once __DIR__ . '/../model/CartModel.php';

CartModel::setConnection($pdo);

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false]);
    exit;
}

$userId = $_SESSION['user_id'];
$productId = $_GET['id'];

$added = CartModel::addToCart($userId, $productId);
$count = CartModel::getCartItemCount($userId);

echo json_encode(['success' => $added, 'count' => $count]);
