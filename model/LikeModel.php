<?php
require_once __DIR__ . '/BaseModel.php';


class LikeModel extends BaseModel
{
    protected $table = 'likes';
    protected $primaryKey = 'like_id';

    public $like_id;
    public $user_id;
    public $product_id;

    public function __construct()
    {
        $this->like_id = null;
        $this->user_id = null;
        $this->product_id = null;
    }

    // Used to insert/update fields in the table
    protected function getFields(): array
    {
        return [
            'user_id' => $this->user_id,
            'product_id' => $this->product_id
        ];
    }

    // Build model instance from array (used by fetchAll or find)
    public static function fromArray(array $data)
    {
        $like = new self();
        $like->like_id = $data['like_id'] ?? null;
        $like->user_id = $data['user_id'] ?? null;
        $like->product_id = $data['product_id'] ?? null;
        return $like;
    }

    // Create table if it doesn't exist
    public static function initializeDatabase()
    {
        global $pdo;
        $stmt = $pdo->prepare("
            CREATE TABLE IF NOT EXISTS likes (
                like_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
        $stmt->execute();
    }

    // Save a like only if not already exists
    public function save()
    {
        global $pdo;

        // Check if like already exists
        $stmt = $pdo->prepare("
            SELECT like_id FROM likes WHERE user_id = :user_id AND product_id = :product_id
        ");
        $stmt->execute([
            ':user_id' => $this->user_id,
            ':product_id' => $this->product_id
        ]);
        if ($stmt->fetch()) {
            return 'exists';
        }

        $success = parent::save();
        return $success ? 'added' : 'error';


    }

    // Get all liked products by user
    public static function getLikeItemsByUser($user_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT l.like_id, p.* 
            FROM likes l
            JOIN product p ON l.product_id = p.product_id
            WHERE l.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count all liked products for a user
  public static function getLikeCount($user_id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT product_id) AS total FROM likes WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'] ?? 0;
}
    // Delete a like by user_id and like_id
    public static function removeFromLike($user_id, $like_id)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            DELETE FROM likes WHERE like_id = :like_id AND user_id = :user_id
        ");
        return $stmt->execute([
            ':like_id' => $like_id,
            ':user_id' => $user_id
        ]);
    }
}
