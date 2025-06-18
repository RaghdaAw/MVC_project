<?php
session_start();
require_once __DIR__ . '/../model/dbConnect.php';
require_once __DIR__ . '/../model/LikeModel.php';

LikeModel::setConnection($db->getConnection());

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

$success = LikeModel::likeProduct($user_id, $product_id);
$count = LikeModel::getLikeCount($user_id);

echo json_encode([
    'success' => $success,
    'count' => $count,
    'message' => $success ? 'Liked successfully' : 'Already liked'
]);
