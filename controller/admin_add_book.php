<form method="POST" action="" enctype="multipart/form-data">
    <input type="text" name="name" required placeholder="Book name "><br><br>
    <input type="text" name="author" required placeholder="author"><br><br>
    <input type="number" name="year" required placeholder="year"><br><br>
    <input type="number" name="price" required placeholder="price"><br><br>
    <textarea name="description" required placeholder="description"></textarea><br><br>
    <input type="file" name="image"><br><br>
    <input type="submit" name="submit" value="add"><br><br>
</form>

<?php
include("../model/dbConnect.php");
include("../model/Book.php");

$book = new Book($pdo);

if (isset($_POST['submit'])) {
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $dir = "../public/uploadImages/";
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true); // إنشاء المجلد إذا لم يكن موجودًا
        }
        $unique_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $dir . $unique_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        }
    }

    $book->insertBook(
        $_POST['name'],
        $_POST['author'],
        $_POST['year'],
        $_POST['price'],
        $_POST['description'],
        $image_url
    );

    echo "✅ تم إضافة الكتاب!";
}
?>
