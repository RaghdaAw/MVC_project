<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();

require_once __DIR__ . '/../model/dbConnect.php';
require_once __DIR__ . '/../model/LikeModel.php';

global $pdo;
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => '❌ You must be logged in and select a book.'
    ]);
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$product_id = (int) $_GET['id'];

try {
    $like = new LikeModel();
    $like->user_id = $user_id;
    $like->product_id = $product_id;

    $result = $like->save();
    $count = LikeModel::getLikeCount($user_id);

    $message = match ($result) {
        'added'  => '✅ Book added to favorites.',
        'exists' => '📚 This book is already in your favorites.',
        default  => '❌ Something went wrong while adding the book.'
    };

    ob_clean();
    echo json_encode([
        'success' => $result === 'added' || $result === 'exists',
        'count' => $count,
        'message' => $message
    ]);
    exit;

} catch (Exception $e) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => '❌ Error: ' . $e->getMessage()
    ]);
    exit;
}