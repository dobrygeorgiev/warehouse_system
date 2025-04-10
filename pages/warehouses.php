<?php
require_once '../db.php';

$sql_warehouses = "SELECT * FROM warehouses";
$stmt_warehouses = $pdo->query($sql_warehouses);
$warehouses = $stmt_warehouses->fetchAll();
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Складове</title>
    <link rel="stylesheet" href="../styles/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #007bff;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: #fff;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e9ecef;
        }

        table td {
            border: 1px solid #ddd;
        }

        .add-warehouse {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .add-warehouse:hover {
            background-color: #218838;
        }

        @media (max-width: 768px) {
            table th, table td {
                font-size: 0.9em;
                padding: 8px;
            }

            .add-warehouse {
                font-size: 0.9em;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Списък на складовете</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Име</th>
                        <th>Местоположение</th>
                        <th>Дата на създаване</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($warehouses as $warehouse): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($warehouse['id']); ?></td>
                            <td><?php echo htmlspecialchars($warehouse['name']); ?></td>
                            <td><?php echo htmlspecialchars($warehouse['location']); ?></td>
                            <td><?php echo htmlspecialchars($warehouse['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="../actions/add_warehouse.php" class="add-warehouse">Добави нов склад</a>
    </div>
</body>
</html>
