<?php

class LikeModel {
    private static $pdo;

    private $like_id;
    public $user_id;
    public $product_id;

    public function __construct() {
        $this->like_id = null;
        $this->user_id = null;
        $this->product_id = null;
    }

    public static function setConnection($db) {
        self::$pdo = $db;
    }

    public function getID() {
        return $this->like_id;
    }

    // إنشاء جدول likes إذا لم يكن موجوداً
    public static function initializeDatabase() {
        $stmt = self::$pdo->prepare("
            CREATE TABLE IF NOT EXISTS likes (
                like_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
        $stmt->execute();
    }

    // حفظ إعجاب (تجنب التكرار)
    public function save() {
        // تحقق من وجود الإعجاب مسبقًا
        $stmt = self::$pdo->prepare("
            SELECT like_id FROM likes WHERE user_id = :user_id AND product_id = :product_id
        ");
        $stmt->execute([
            ':user_id' => $this->user_id,
            ':product_id' => $this->product_id
        ]);

        if ($stmt->fetch()) {
            return false; // موجود مسبقاً
        }

        // إدخال جديد
        $stmt = self::$pdo->prepare("
            INSERT INTO likes (user_id, product_id) 
            VALUES (:user_id, :product_id)
        ");
        $stmt->execute([
            ':user_id' => $this->user_id,
            ':product_id' => $this->product_id
        ]);

        $this->like_id = self::$pdo->lastInsertId();
        return true;
    }

    // حذف الإعجاب
    public function delete() {
        if (!$this->like_id) {
            throw new Exception("Like doesn't exist.");
        }

        $stmt = self::$pdo->prepare("DELETE FROM likes WHERE like_id = :like_id");
        $stmt->execute([':like_id' => $this->like_id]);

        $this->like_id = null;
        $this->user_id = null;
        $this->product_id = null;
    }

    // تحميل إعجاب حسب ID
    public static function load($like_id) {
        $stmt = self::$pdo->prepare("SELECT * FROM likes WHERE like_id = :like_id");
        $stmt->execute([':like_id' => $like_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        return self::loadSingleResult($data);
    }

    public static function loadSingleResult($data) {
        if (!isset($data['like_id'], $data['user_id'], $data['product_id'])) {
            throw new Exception("Missing like data");
        }

        $like = new self();
        $like->like_id = $data['like_id'];
        $like->user_id = $data['user_id'];
        $like->product_id = $data['product_id'];

        return $like;
    }

    // استرجاع المنتجات المعجب بها لمستخدم
    public static function getLikeItemsByUser($user_id) {
        $stmt = self::$pdo->prepare("
            SELECT l.like_id, p.* 
            FROM likes l
            JOIN product p ON l.product_id = p.product_id
            WHERE l.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // عدّ الإعجابات لمستخدم
    public static function getLikeCount($user_id) {
        $stmt = self::$pdo->prepare("
            SELECT COUNT(*) AS total FROM likes WHERE user_id = :user_id
        ");
        $stmt->execute([':user_id' => $user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // حذف إعجاب باستخدام user_id و like_id
    public static function removeFromLike($user_id, $like_id) {
        $stmt = self::$pdo->prepare("
            DELETE FROM likes WHERE like_id = :like_id AND user_id = :user_id
        ");
        return $stmt->execute([
            ':like_id' => $like_id,
            ':user_id' => $user_id
        ]);
    }
}
include_once 'model/LikeModel.php';
LikeModel::setConnection($pdo);
LikeModel::initializeDatabase();

// إضافة إعجاب
$like = new LikeModel();
$like->user_id = 1;
$like->product_id = 12;
$like->save();

// حذف إعجاب
$like = LikeModel::load(5);
if ($like) $like->delete();

// عدد الإعجابات
$count = LikeModel::getLikeCount(1);

// المنتجات المعجب بها
$items = LikeModel::getLikeItemsByUser(1);
