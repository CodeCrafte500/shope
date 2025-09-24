<?php
include 'connection.php';

// Check if the request method is POST and the product ID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Prepare and execute SQL query to delete the product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        echo "Product deleted successfully.";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Invalid request method or missing product ID.";
}

$conn->close();
header("Location: delete_update_products_form.php?message=Product deleted successfully");
exit; // Ensure no further output is sent after the redirect
?>
