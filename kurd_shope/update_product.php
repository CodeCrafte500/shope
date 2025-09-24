<?php
include 'connection.php';

// Debugging: Check request method and submitted data
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Error: Invalid request method. Expected POST.");
}

if (!isset($_POST['productId'])) {
    die("Error: Missing product ID.");
}

$productId = $_POST['productId'];
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
$stmt = $conn->prepare("UPDATE products SET productName = ?, productNameEn = ?, productDescription = ?, productPrice = ?, productOriginalPrice = ?, productImage = ?, productCategory = ?, productBrand = ? WHERE id = ?");
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("sssiisssi", $productName, $productNameEn, $productDescription, $productPrice, $productOriginalPrice, $productImage, $productCategory, $productBrand, $productId);

if ($stmt->execute()) {
    echo "Product updated successfully.";
} else {
    echo "Error executing statement: " . $stmt->error;
}

$stmt->close();
$conn->close();
header("Location: delete_update_products_form.php?message=Product updated successfully");
exit; // Ensure no further output is sent after the redirect
?>