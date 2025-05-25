<form method="POST" action="" enctype="multipart/form-data">
    <input type="text" name="name" required placeholder="اسم الكتاب">
    <input type="text" name="author" required placeholder="الكاتب">
    <input type="number" name="year" required placeholder="سنة النشر">
    <input type="number" name="price" required placeholder="السعر">
    <textarea name="description" required placeholder="الوصف"></textarea>
    <input type="file" name="image">
    <input type="submit" name="submit" value="إضافة">
</form>

<?php
include("../model/dbConnect.php");
include("../model/Book.php");

$book = new Book($pdo);

if (isset($_POST['submit'])) {
    $image_url = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $dir = "uploadImages/";
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
