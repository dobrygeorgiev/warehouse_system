<?php
require_once '../db.php';

function validatePhone($phone) {
    $pattern = '/^(\+359|0)\d{9}$/';
    return preg_match($pattern, $phone);
}

function validateEmail($email) {
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return preg_match($pattern, $email);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_supplier'])) {
    $name = $_POST['name'];
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $address = isset($_POST['address']) ? $_POST['address'] : null;

    if ($phone && !validatePhone($phone)) {
        echo "Невалиден телефонен номер!";
        exit;
    }

    if ($email && !validateEmail($email)) {
        echo "Невалиден имейл адрес!";
        exit;
    }

    $sql = "INSERT INTO suppliers (name, phone, email, address) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $phone, $email, $address]);

    header("Location: suppliers.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добави доставчик</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Добави доставчик</h1>

        <form method="POST" action="add_supplier.php">
            <label for="name">Име на доставчик:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Телефон:</label>
            <input type="text" id="phone" name="phone">

            <label for="email">Имейл:</label>
            <input type="email" id="email" name="email">

            <label for="address">Адрес:</label>
            <textarea id="address" name="address"></textarea>

            <input style="width: fit-content; align-self: center" type="submit" name="add_supplier" value="Добави доставчик">
        </form>

        <div class="back-link">
            <a href="suppliers.php">Назад към списъка</a>
        </div>
    </div>
</body>
</html>
