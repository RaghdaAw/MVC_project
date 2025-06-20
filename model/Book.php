<?php
include_once __DIR__ . "/dbConnect.php";

class Book
{
    private $id_product;
    public $name;
    public $author;
    public $year;
    public $price;
    public $description;
    public $image_url;

    public function __construct()
    {
        $this->id_product = null;
        $this->name = "";
        $this->author = "";
        $this->year = "";
        $this->price = "";
        $this->description = "";
        $this->image_url = "";
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

    public function getID()
    {
        return $this->id_product;
    }

    public function save()
    {
        global $pdo;
        if ($this->id_product !== null) {
            $stmt = $pdo->prepare(
                "UPDATE product SET name = :name, author = :author, year = :year,
                 price = :price, description = :description, image_url = :image_url 
                 WHERE product_id = :id_product"
            );
            $stmt->execute([
                ':name' => $this->name,
                ':author' => $this->author,
                ':year' => $this->year,
                ':price' => $this->price,
                ':description' => $this->description,
                ':image_url' => $this->image_url,
                ':id_product' => $this->id_product
            ]);
        } else {
            $stmt = $pdo->prepare(
                "INSERT INTO product (name, author, year, price, description, image_url)
                 VALUES (:name, :author, :year, :price, :description, :image_url)"
            );
            $stmt->execute([
                ':name' => $this->name,
                ':author' => $this->author,
                ':year' => $this->year,
                ':price' => $this->price,
                ':description' => $this->description,
                ':image_url' => $this->image_url
            ]);

            $this->id = $pdo->lastInsertId();
        }
    }

    public function delete()
    {
        global $pdo;
        if ($this->id_product === null) {
            throw new Exception("Book does not exist in database.");
        }

        // Delete image if exists
        if (!empty($this->image_url) && file_exists($this->image_url)) {
            unlink($this->image_url);
        }

        $stmt = $pdo->prepare("DELETE FROM product WHERE product_id = :id_product");
        $stmt->execute([':id_product' => $this->id_product]);

        // Clear object
        $this->id = null;
        $this->name = null;
        $this->author = null;
        $this->year = null;
        $this->price = null;
        $this->description = null;
        $this->image_url = null;
    }

    public static function load($id_product)
    {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = :id_product");
        $stmt->execute([':id_product' => $id_product]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return self::fromArray($data);
    }

    public static function getAll()
    {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM product");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'fromArray'], $rows);
    }

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

    public static function fromArray($data)
    {
        $book = new self();
        $book->id_product = $data['product_id'];
        $book->name = $data['name'];
        $book->author = $data['author'];
        $book->year = $data['year'];
        $book->price = $data['price'];
        $book->description = $data['description'];
        $book->image_url = $data['image_url'];
        return $book;
    }
}
