<?php
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    $sql = "INSERT INTO categories (name) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name]);

    header('Location: ../pages/categories.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавяне на категория</title>
</head>
<body>
    <h1>Добавяне на нова категория</h1>
    <form action="" method="post">
        <label>Име на категория: <input type="text" name="name" required></label><br>
        <button type="submit">Добави</button>
    </form>
</body>
</html>
