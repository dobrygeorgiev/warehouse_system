<?php
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_warehouse'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];

    $sql_insert_warehouse = "INSERT INTO warehouses (name, location) VALUES (?, ?)";
    $stmt_insert_warehouse = $pdo->prepare($sql_insert_warehouse);
    $stmt_insert_warehouse->execute([$name, $location]);

    header("Location: ../pages/warehouses.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добави склад</title>
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #007bff;
        }

        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: left;
        }

        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            box-sizing: border-box;
        }

        form textarea {
            resize: none;
            height: 80px;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Добави нов склад</h1>

        <form method="POST">
            <label for="name">Име на склада:</label>
            <input type="text" id="name" name="name" required placeholder="Въведете име на склада">

            <label for="location">Местоположение на склада:</label>
            <textarea id="location" name="location" required placeholder="Въведете местоположение"></textarea>

            <input type="submit" name="add_warehouse" value="Добави склад">
        </form>

        <a href="../pages/warehouses.php" class="back-link">Назад към складовете</a>
    </div>
</body>
</html>
