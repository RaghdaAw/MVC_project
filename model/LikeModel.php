<?php
class LikeModel {
    protected static $pdo;

    public static function setConnection($pdo) {
        self::$pdo = $pdo;
    }

    public static function likeProduct($user_id, $product_id) {
        $stmt = self::$pdo->prepare("SELECT * FROM likes WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);

        if ($stmt->fetch()) {
            return false; // تم عمل like مسبقًا
        }

        $stmt = self::$pdo->prepare("INSERT INTO likes (user_id, product_id) VALUES (?, ?)");
        return $stmt->execute([$user_id, $product_id]);
    }

  public static function getLikeItems($user_id)
{
    $stmt = self::$pdo->prepare("
        SELECT c.like_id, p.* FROM likes c 
        JOIN product p ON c.product_id = p.product_id 
        WHERE c.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


       public static function getLikeCount($user_id)
    {
        $stmt = self::$pdo->prepare("SELECT COUNT(*) AS total FROM likes WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

 public static function removeFromLike($user_id, $like_id)
{
    $stmt = self::$pdo->prepare("DELETE FROM likes WHERE like_id = :like_id AND user_id = :user_id");
    return $stmt->execute([
        ':like_id' => $like_id,
        ':user_id' => $user_id
    ]);
}

    
}
