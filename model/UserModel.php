<?php
require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    public $user_id;
    public $firstname;
    public $lastname;
    public $username;
    public $password; // raw password عند الإدخال فقط
    public $role;

    public function __construct()
    {
        $this->user_id = null;
        $this->firstname = '';
        $this->lastname = '';
        $this->username = '';
        $this->password = '';
        $this->role = 'user';
    }

    protected function getFields(): array
    {
        $fields = [
            'firstname' => $this->firstname,
            'lastname'  => $this->lastname,
            'username'  => $this->username,
            'role'      => $this->role
        ];

        if ($this->user_id === null && !empty($this->password)) {
            $fields['password'] = password_hash($this->password, PASSWORD_DEFAULT);
        }

        return $fields;
    }

    public static function fromArray(array $data): self
    {
        $user = new self();
        $user->user_id   = $data['user_id'] ?? null;
        $user->firstname = $data['firstname'] ?? '';
        $user->lastname  = $data['lastname'] ?? '';
        $user->username  = $data['username'] ?? '';
        $user->role      = $data['role'] ?? '';
        return $user;
    }

    public static function login($username, $password)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password'])) {
            return self::fromArray($userData);
        }

        return false;
    }

    public static function initializeDatabase()
    {
        global $pdo;
        $stmt = $pdo->prepare("
            CREATE TABLE IF NOT EXISTS users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(100) NOT NULL,
                lastname VARCHAR(100) NOT NULL,
                username VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL
            );
        ");
        $stmt->execute();
    }

    // ✅ دوال مطلوبة من UserController
    public static function getAllUsers(): array
    {
        return self::findAll();
    }

    public static function load(int $id): ?self
    {
        return self::findByID($id);
    }
}
