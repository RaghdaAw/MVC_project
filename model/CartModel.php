<?php

class CartModel
{
    private static $pdo;

    private $cart_id;
    public $user_id;
    public $product_id;
    public $quantity; // أضف خاصية الكمية

    public function __construct()
    {
        $this->cart_id = null;
        $this->user_id = null;
        $this->product_id = null;
        $this->quantity = 1;  // القيمة الافتراضية 1
    }

    public static function setConnection($db)
    {
        self::$pdo = $db;
    }

    public function getID()
    {
        return $this->cart_id;
    }

    // إنشاء الجدول إذا لم يكن موجودًا (يشمل العمود quantity)
    public static function initializeDatabase()
    {
        $stmt = self::$pdo->prepare("
            CREATE TABLE IF NOT EXISTS cart (
                cart_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL DEFAULT 1,
                added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
        $stmt->execute();
    }

    public function save()
    {
        if ($this->cart_id !== null) {
            $stmt = self::$pdo->prepare("
                UPDATE cart 
                SET user_id = :user_id, product_id = :product_id, quantity = :quantity
                WHERE cart_id = :cart_id
            ");
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':product_id' => $this->product_id,
                ':quantity' => $this->quantity,
                ':cart_id' => $this->cart_id
            ]);
        } else {
            $stmt = self::$pdo->prepare("
                INSERT INTO cart (user_id, product_id, quantity) 
                VALUES (:user_id, :product_id, :quantity)
            ");
            $stmt->execute([
                ':user_id' => $this->user_id,
                ':product_id' => $this->product_id,
                ':quantity' => $this->quantity
            ]);
            $this->cart_id = self::$pdo->lastInsertId();
        }
    }

    public function delete()
    {
        if (!$this->cart_id) {
            throw new Exception("Item doesn't exist in db");
        }

        $stmt = self::$pdo->prepare("
            DELETE FROM cart WHERE cart_id = :cart_id
        ");
        $stmt->execute([':cart_id' => $this->cart_id]);

        // Reset properties
        $this->cart_id = null;
        $this->user_id = null;
        $this->product_id = null;
        $this->quantity = 1;
    }

    public static function load($cart_id)
    {
        $stmt = self::$pdo->prepare("
            SELECT * FROM cart WHERE cart_id = :cart_id
        ");
        $stmt->execute([':cart_id' => $cart_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return self::loadSingleResult($data);
    }

    public static function loadSingleResult($data)
    {
        if (!isset($data['cart_id'], $data['user_id'], $data['product_id'], $data['quantity'])) {
            throw new Exception("Missing data for cart item");
        }

        $cartItem = new self();
        $cartItem->cart_id = $data['cart_id'];
        $cartItem->user_id = $data['user_id'];
        $cartItem->product_id = $data['product_id'];
        $cartItem->quantity = $data['quantity'];

        return $cartItem;
    }

    // جلب كل عناصر السلة مع بيانات المنتج والكمية
    public static function getCartItemsByUser($user_id)
    {
        $stmt = self::$pdo->prepare("
            SELECT c.cart_id, c.user_id, c.product_id, c.quantity, p.*
            FROM cart c
            JOIN product p ON c.product_id = p.product_id
            WHERE c.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // حساب عدد العناصر (يمكن حساب مجموع الكميات إذا أردت)
    public static function getCartItemCount($user_id)
    {
        $stmt = self::$pdo->prepare("
            SELECT SUM(quantity) AS total FROM cart WHERE user_id = :user_id
        ");
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public static function decreaseOrDelete($cart_id)
{
    // تحميل العنصر من قاعدة البيانات
    $stmt = self::$pdo->prepare("SELECT * FROM cart WHERE cart_id = :cart_id");
    $stmt->execute([':cart_id' => $cart_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        throw new Exception("Item not found");
    }

    if ($item['quantity'] > 1) {
        // إذا الكمية أكبر من 1: أنقصها
        $stmt = self::$pdo->prepare("
            UPDATE cart SET quantity = quantity - 1 WHERE cart_id = :cart_id
        ");
        $stmt->execute([':cart_id' => $cart_id]);
    } else {
        // إذا الكمية = 1: احذف السطر
        $stmt = self::$pdo->prepare("
            DELETE FROM cart WHERE cart_id = :cart_id
        ");
        $stmt->execute([':cart_id' => $cart_id]);
    }
}

}
