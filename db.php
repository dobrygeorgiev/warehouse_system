<?php
$host = '127.0.0.1';
$port = 3306;
$dbname = 'warehouse_system';
$username = 'root';
$password = 'dobrilocalmysql';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Грешка при връзката с базата данни: " . $e->getMessage());
}
?>
