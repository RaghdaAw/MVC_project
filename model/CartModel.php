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
            SELECT p.* FROM cart c 
            JOIN product p ON c.product_id = p.product_id 
            WHERE c.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public static function removeFromCart($user_id, $product_id)
{
    $stmt = self::$pdo->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    return $stmt->execute([
        ':user_id' => $user_id,
        ':product_id' => $product_id
    ]);
}

}
