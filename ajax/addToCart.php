<?php
session_start();
require_once __DIR__ . '/../model/dbConnect.php';
require_once __DIR__ . '/../model/CartModel.php';

global $pdo;

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$userId = $_SESSION['user_id'];
$productId = $_GET['id'];

try {
    // تحقق إذا المنتج موجود مسبقًا في السلة
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute([':user_id' => $userId, ':product_id' => $productId]);
    $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingItem) {
        // المنتج موجود: زود الكمية بواحد
       $cartItem = CartModel::findByID($existingItem['cart_id']);
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        // المنتج غير موجود: أنشئ عنصر جديد بالكمية 1
        $cartItem = new CartModel();
        $cartItem->user_id = $userId;
        $cartItem->product_id = $productId;
        $cartItem->quantity = 1;
        $cartItem->save();
    }

    // احصل على العدد الكلي للقطع (مجموع الكميات)
    $count = CartModel::getCartItemCount($userId);

    echo json_encode(['success' => true, 'count' => $count]);
} catch (Exception $e) {
    error_log("Cart error: " . $e->getMessage());
    echo json_encode(['success' => false]);
}
exit;



