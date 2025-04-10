<?php
require_once '../db.php';

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        // If the product is not found, redirect back to the products page with an error message
        header("Location: ../pages/products.php");
        exit;
    }
} else {
    // If no product ID is provided, redirect back to the products page
    header("Location: ../pages/products.php");
    exit;
}

// Handle the form submission to update the product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    // Get the updated product data from the form
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $supplier_id = $_POST['supplier_id'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql_update = "UPDATE products SET name = ?, category_id = ?, supplier_id = ?, price = ?, stock_quantity = ? WHERE id = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$name, $category_id, $supplier_id, $price, $stock_quantity, $productId]);

    header("Location: ../pages/products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирай продукт</title>
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: 0 auto;
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
        <h1>Редактирай продукт</h1>
        <form method="POST">
            <label for="name">Име на продукта:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label for="category_id">Категория:</label>
            <select id="category_id" name="category_id" required>
                <option value="" disabled>Изберете категория</option>
                <?php
                $sql_categories = "SELECT * FROM categories";
                $stmt_categories = $pdo->query($sql_categories);
                $categories = $stmt_categories->fetchAll();
                foreach ($categories as $category):
                    ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="supplier_id">Доставчик:</label>
            <select id="supplier_id" name="supplier_id" required>
                <option value="" disabled>Изберете доставчик</option>
                <?php
                $sql_suppliers = "SELECT * FROM suppliers";
                $stmt_suppliers = $pdo->query($sql_suppliers);
                $suppliers = $stmt_suppliers->fetchAll();
                foreach ($suppliers as $supplier):
                    ?>
                    <option value="<?= $supplier['id'] ?>" <?= $supplier['id'] == $product['supplier_id'] ? 'selected' : '' ?>><?= $supplier['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="price">Цена:</label>
            <input type="text" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

            <label for="stock_quantity">Количество:</label>
            <input type="number" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>

            <input type="submit" name="update_product" value="Актуализирай продукт">
        </form>
    </div>
</body>
</html>
