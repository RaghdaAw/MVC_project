<?php
require_once __DIR__ . '/dbConnect.php';
require_once __DIR__ . '/BaseModel.php';

class CartModel extends BaseModel
{
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';

    public $cart_id;
    public $user_id;
    public $product_id;
    public $quantity;

    public function __construct()
    {
        $this->cart_id = null;
        $this->user_id = null;
        $this->product_id = null;
        $this->quantity = 1;
    }

    protected function getFields(): array
    {
        return [
            'user_id'    => $this->user_id,
            'product_id' => $this->product_id,
            'quantity'   => $this->quantity,
        ];
    }

    public static function fromArray(array $data)
    {
        $item = new self();
        $item->cart_id    = $data['cart_id'] ?? null;
        $item->user_id    = $data['user_id'] ?? null;
        $item->product_id = $data['product_id'] ?? null;
        $item->quantity   = $data['quantity'] ?? 1;
        return $item;
    }

    public static function initializeDatabase()
    {
        global $pdo;
        $stmt = $pdo->prepare("
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

    // جلب عناصر السلة للمستخدم مع بيانات المنتجات
    public static function getCartItemsByUser($user_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT c.*, p.*
            FROM cart c
            JOIN product p ON c.product_id = p.product_id
            WHERE c.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // حساب العدد الإجمالي للعناصر في السلة
    public static function getCartItemCount($user_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT SUM(quantity) AS total FROM cart WHERE user_id = :user_id
        ");
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public static function decreaseOrDelete($cart_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE cart_id = :cart_id");
        $stmt->execute([':cart_id' => $cart_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return;

        if ($data['quantity'] > 1) {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity - 1 WHERE cart_id = :cart_id");
            $stmt->execute([':cart_id' => $cart_id]);
        } else {
            $stmt = $pdo->prepare("DELETE FROM cart WHERE cart_id = :cart_id");
            $stmt->execute([':cart_id' => $cart_id]);
        }
    }
}
