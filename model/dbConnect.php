<?php
$host = "localhost";
$dbname = "library";
$username = "root";
$password = "";

$pdo = null;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful"."<br>";
} catch (PDOException $e) {
    throw new Exception("Database connection failed: " . $e->getMessage());
}