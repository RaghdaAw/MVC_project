<?php
require_once __DIR__ . '/BaseModel.php';

class Book extends BaseModel
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    public $product_id; 
    public $name;
    public $author;
    public $year;
    public $price;
    public $description;
    public $image_url;

    public function __construct()
    {
        $this->product_id = null;
        $this->name = "";
        $this->author = "";
        $this->year = 0;
        $this->price = 0.0;
        $this->description = "";
        $this->image_url = "";
    }

    
    protected function getFields(): array
    {
        return [
            'name' => $this->name,
            'author' => $this->author,
            'year' => $this->year,
            'price' => $this->price,
            'description' => $this->description,
            'image_url' => $this->image_url
        ];
    }

    public static function initializeDatabase()
    {
        global $pdo;
        $pdo->prepare(
            "CREATE TABLE IF NOT EXISTS product (
                product_id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                author VARCHAR(255) NOT NULL,
                year INT NOT NULL,
                price FLOAT NOT NULL,
                description TEXT,
                image_url VARCHAR(255)
            );"
        )->execute();
    }

    public function delete()
    {
        global $pdo;

        if ($this->product_id === null) {
            throw new Exception("Book does not exist in database.");
        }
      // delete image if exists
        if (!empty($this->image_url) && file_exists($this->image_url)) {
            unlink($this->image_url);
        }

        parent::delete(); 
    }

    public static function fromArray(array $data)
    {
        $book = new self();
        $book->product_id = $data['product_id'];
        $book->name = $data['name'];
        $book->author = $data['author'];
        $book->year = $data['year'];
        $book->price = $data['price'];
        $book->description = $data['description'];
        $book->image_url = $data['image_url'];
        return $book;
    }

    // يمكن إضافة دوال خاصة مثل البحث هنا إن أردت، مثلاً:
    public static function search($keyword)
    {
        global $pdo;
        $stmt = $pdo->prepare("
            SELECT * FROM product 
            WHERE name LIKE :kw OR author LIKE :kw OR description LIKE :kw
                  OR CAST(year AS CHAR) LIKE :kw OR CAST(price AS CHAR) LIKE :kw
        ");
        $stmt->execute([':kw' => '%' . $keyword . '%']);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromArray'], $rows);
    }
}
