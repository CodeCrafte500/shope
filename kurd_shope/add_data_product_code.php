<?php
include 'connection.php';

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'] ?? null;
    $productNameEn = $_POST['productNameEn'] ?? null;
    $productDescription = $_POST['productDescription'] ?? null;
    $productPrice = $_POST['productPrice'] ?? null;
    $productOriginalPrice = $_POST['productOriginalPrice'] ?? null;
    $productImage = $_POST['productImage'] ?? null;
    $productCategory = $_POST['productCategory'] ?? null;
    $productBrand = $_POST['productBrand'] ?? null;

    // Validate required fields
    if (!$productName || !$productNameEn || !$productPrice || !$productImage || !$productCategory || !$productBrand) {
        die("Error: Missing required fields.");
    }

    // Prepare and execute SQL query
    $stmt = $conn->prepare("INSERT INTO products (productName, productNameEn, productDescription, productPrice, productOriginalPrice, productImage, productCategory, productBrand) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssiisss", $productName, $productNameEn, $productDescription, $productPrice, $productOriginalPrice, $productImage, $productCategory, $productBrand);

    if ($stmt->execute()) {
        echo "Product added successfully.";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error: Invalid request method.";
}

$conn->close();
header("Location: add_data_form.php?message=Product added successfully");
exit; // Ensure no further output is sent after the redirect
?>