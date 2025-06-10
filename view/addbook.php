
<?php
require_once '../controller/BookController.php';
   

?>
<form method="POST" action="" enctype="multipart/form-data">
    <input type="text" name="name" required placeholder="Book name "><br><br>
    <input type="text" name="author" required placeholder="author"><br><br>
    <input type="number" name="year" required placeholder="year"><br><br>
    <input type="number" name="price" required placeholder="price"><br><br>
    <textarea name="description" required placeholder="description"></textarea><br><br>
    <input type="file" name="image"><br><br>
    <input type="submit" name="submit" value="add"><br><br>
</form>
