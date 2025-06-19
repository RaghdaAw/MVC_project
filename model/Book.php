<?php

class Book
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function bindParams($stmt, $data)
    {
        foreach ($data as $param => $value) {
            $stmt->bindValue(':' . $param, $value);
        }
    }

    public function getAllBooks()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertBook($BookData)
    {
        $data = compact('name', 'author', 'year', 'price', 'description', 'image_url');
        $sql = "INSERT INTO product (name, author, year, price, description, image_url)
                VALUES (:name, :author, :year, :price, :description, :image_url)";
        $stmt = $this->pdo->prepare($sql);
        $this->bindParams($stmt, $data);
        return $stmt->execute();
    }

    public function deleteBook($product_id)
    {
        $stmt = $this->pdo->prepare("SELECT image_url FROM product WHERE product_id = :id");
        $stmt->bindValue(':id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($book && !empty($book['image_url']) && file_exists($book['image_url'])) {
            unlink($book['image_url']);
        }

        $stmt = $this->pdo->prepare("DELETE FROM product WHERE product_id = :id");
        $stmt->bindValue(':id', $product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateBook($BookData)
    {
        $data = compact('product_id', 'name', 'author', 'year', 'price', 'description', 'image_url');
        $sql = "UPDATE product 
                SET name = :name, author = :author, year = :year, price = :price,
                    description = :description, image_url = :image_url 
                WHERE product_id = :product_id";
        $stmt = $this->pdo->prepare($sql);
        $this->bindParams($stmt, $data);
        return $stmt->execute();
    }

    public function getBookById($product_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE product_id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchBooks($keyword)
    {
        $sql = "SELECT * FROM product 
                WHERE name LIKE :keyword 
                   OR author LIKE :keyword 
                   OR description LIKE :keyword 
                   OR CAST(year AS CHAR) LIKE :keyword 
                   OR CAST(price AS CHAR) LIKE :keyword";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
