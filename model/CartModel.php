<?php
class CartModel
{
    private static $pdo;

    public static function setConnection($pdo)
    {
        self::$pdo = $pdo;
    }

    public static function addToCart($user_id, $product_id)
    {
        $stmt = self::$pdo->prepare("INSERT INTO cart (user_id, product_id) VALUES (:user_id, :product_id)");
        return $stmt->execute([
            ':user_id' => $user_id,
            ':product_id' => $product_id
        ]);
    }

  public static function getCartItems($user_id)
{
    $stmt = self::$pdo->prepare("
        SELECT c.cart_id, p.* FROM cart c 
        JOIN product p ON c.product_id = p.product_id 
        WHERE c.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public static function getCartItemCount($user_id)
    {
        $stmt = self::$pdo->prepare("SELECT COUNT(*) AS total FROM cart WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

 public static function removeFromCart($user_id, $cart_id)
{
    $stmt = self::$pdo->prepare("DELETE FROM cart WHERE cart_id = :cart_id AND user_id = :user_id");
    return $stmt->execute([
        ':cart_id' => $cart_id,
        ':user_id' => $user_id
    ]);
}



}
