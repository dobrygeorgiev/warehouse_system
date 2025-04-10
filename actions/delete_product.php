<?php
session_start();

require_once '../db.php';

// Check if the product ID is set in the URL
if (isset($_GET['id'])) {
    // Get the product ID from the URL
    $productId = $_GET['id'];

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$productId])) {
        // Set a success message to display after deletion
        $_SESSION['success_message'] = "Продуктът беше успешно изтрит.";
    } else {
        // Set an error message if deletion fails
        $_SESSION['error_message'] = "Възникна грешка при изтриването на продукта.";
    }
} else {
    // If no product ID is provided, set an error message
    $_SESSION['error_message'] = "Продуктът не беше намерен.";
}

header("Location: ../pages/products.php");
exit;
?>
