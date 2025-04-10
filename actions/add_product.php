<?php
require_once '../db.php';

$sql_categories = "SELECT * FROM categories";
$stmt_categories = $pdo->query($sql_categories);
$categories = $stmt_categories->fetchAll();

$sql_suppliers = "SELECT * FROM suppliers";
$stmt_suppliers = $pdo->query($sql_suppliers);
$suppliers = $stmt_suppliers->fetchAll();

$sql_warehouses = "SELECT * FROM warehouses";
$stmt_warehouses = $pdo->query($sql_warehouses);
$warehouses = $stmt_warehouses->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $warehouse_id = $_POST['warehouse_id'];

    $sql_check_product = "SELECT * FROM products WHERE name = ? AND supplier_id = ?";
    $stmt_check_product = $pdo->prepare($sql_check_product);
    $stmt_check_product->execute([$name, $supplier_id]);
    $existing_product = $stmt_check_product->fetch();

    if ($existing_product) {
        $product_id = $existing_product['id'];
        $new_quantity = $existing_product['stock_quantity'] + $quantity;

        $sql_update_product = "UPDATE products SET stock_quantity = ? WHERE id = ?";
        $stmt_update_product = $pdo->prepare($sql_update_product);
        $stmt_update_product->execute([$new_quantity, $product_id]);

        $sql_check_warehouse_stock = "SELECT * FROM warehouse_stock WHERE warehouse_id = ? AND product_id = ?";
        $stmt_check_warehouse_stock = $pdo->prepare($sql_check_warehouse_stock);
        $stmt_check_warehouse_stock->execute([$warehouse_id, $product_id]);
        $existing_stock = $stmt_check_warehouse_stock->fetch();

        if ($existing_stock) {
            $new_stock_quantity = $existing_stock['stock_quantity'] + $quantity;
            $sql_update_stock = "UPDATE warehouse_stock SET stock_quantity = ? WHERE warehouse_id = ? AND product_id = ?";
            $stmt_update_stock = $pdo->prepare($sql_update_stock);
            $stmt_update_stock->execute([$new_stock_quantity, $warehouse_id, $product_id]);
        } else {
            $sql_insert_stock = "INSERT INTO warehouse_stock (warehouse_id, product_id, stock_quantity) VALUES (?, ?, ?)";
            $stmt_insert_stock = $pdo->prepare($sql_insert_stock);
            $stmt_insert_stock->execute([$warehouse_id, $product_id, $quantity]);
        }

    } else {
        $sql_insert_product = "INSERT INTO products (name, category_id, supplier_id, price, stock_quantity) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert_product = $pdo->prepare($sql_insert_product);
        $stmt_insert_product->execute([$name, $category_id, $supplier_id, $price, $quantity]);
        $product_id = $pdo->lastInsertId();

        $sql_insert_stock = "INSERT INTO warehouse_stock (warehouse_id, product_id, stock_quantity) VALUES (?, ?, ?)";
        $stmt_insert_stock = $pdo->prepare($sql_insert_stock);
        $stmt_insert_stock->execute([$warehouse_id, $product_id, $quantity]);
    }

    header("Location: ../pages/products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добави продукт</title>
    <link rel="stylesheet" href="../styles/style.css">
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
            height: 100vh;
        }

        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #007bff;
            text-align: center;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-container input, .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .form-container input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 15px;
            font-size: 1em;
            font-weight: bold;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-container .note {
            font-size: 0.9em;
            color: #888;
            margin-top: -10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Добави нов продукт</h1>
        <form method="POST">
            <label for="name">Име на продукта:</label>
            <input type="text" id="name" name="name" required placeholder="Въведете името на продукта">

            <label for="category_id">Категория:</label>
            <select id="category_id" name="category_id" required>
                <option value="" disabled selected>Изберете категория</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="supplier_id">Доставчик:</label>
            <select id="supplier_id" name="supplier_id" required>
                <option value="" disabled selected>Изберете доставчик</option>
                <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="price">Цена:</label>
            <input type="text" id="price" name="price" required placeholder="Въведете цената">

            <label for="quantity">Количество:</label>
            <input type="number" id="quantity" name="quantity" required placeholder="Въведете количество">

            <label for="warehouse_id">Склад:</label>
            <select id="warehouse_id" name="warehouse_id" required>
                <option value="" disabled selected>Изберете склад</option>
                <?php foreach ($warehouses as $warehouse): ?>
                    <option value="<?php echo $warehouse['id']; ?>"><?php echo $warehouse['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="add_product" value="Добави продукт">
        </form>
    </div>
</body>
</html>