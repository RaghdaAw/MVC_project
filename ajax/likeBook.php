<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();

require_once __DIR__ . '/../model/dbConnect.php';
require_once __DIR__ . '/../model/LikeModel.php';

LikeModel::setConnection($pdo);

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => '❌ Missing user or product ID.'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

try {
    $like = new LikeModel();
    $like->user_id = $user_id;
    $like->product_id = $product_id;

    $success = $like->save();
    $count = LikeModel::getLikeCount($user_id);

    ob_clean(); // مهم جدًا
    echo json_encode([
        'success' => $success,
        'count' => $count,
        'message' => $success ? '✅ Liked successfully.' : '⚠️ Already added to favorites.'
    ]);
    exit;
} catch (Exception $e) {
    ob_clean(); // مهم أيضًا
    echo json_encode([
        'success' => false,
        'message' => '❌ Error: ' . $e->getMessage()
    ]);
    exit;
}

