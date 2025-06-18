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

    public static function getLikeCount($user_id) {
        $stmt = self::$pdo->prepare("SELECT COUNT(*) FROM likes WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }
}
