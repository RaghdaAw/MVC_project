<?php
include("dbConnect.php");
class Book
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllBooks()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   public function insertBook($name, $author, $year, $price, $description, $image_url = null)
{
    $sql = "INSERT INTO product (name, author, year, price, description, image_url)
            VALUES (:name, :author, :year, :price, :description, :image_url)";
    $stmt = $this->pdo->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image_url', $image_url);

    return $stmt->execute();
}

public function deleteBook($product_id)
    {
        $stmt = $this->pdo->prepare("SELECT image_url FROM product WHERE product_id = :id");
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($book && !empty($book['image_url']) && file_exists($book['image_url'])) {
            unlink($book['image_url']);
        }

        $stmt = $this->pdo->prepare("DELETE FROM product WHERE product_id = :id");
        $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}
