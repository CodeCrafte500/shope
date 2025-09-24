<?php
include 'connection.php';

// Check if productId is provided
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Error: Product not found.");
    }

    $stmt->close();
} else {
    die("Error: Missing product ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="POST" action="update_product.php">
            <input type="hidden" name="productId" value="<?= htmlspecialchars($product['id']) ?>">
            <div class="form-group">
                <label for="productName">Product Name (Kurdish):</label>
                <input type="text" id="productName" name="productName" value="<?= htmlspecialchars($product['productName']) ?>" required>
            </div>
            <div class="form-group">
                <label for="productNameEn">Product Name (English):</label>
                <input type="text" id="productNameEn" name="productNameEn" value="<?= htmlspecialchars($product['productNameEn']) ?>" required>
            </div>
            <div class="form-group">
                <label for="productDescription">Description:</label>
                <textarea id="productDescription" name="productDescription" required><?= htmlspecialchars($product['productDescription']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="productPrice">Price:</label>
                <input type="number" id="productPrice" name="productPrice" value="<?= htmlspecialchars($product['productPrice']) ?>" required>
            </div>
            <div class="form-group">
                <label for="productOriginalPrice">Original Price:</label>
                <input type="number" id="productOriginalPrice" name="productOriginalPrice" value="<?= htmlspecialchars($product['productOriginalPrice']) ?>">
            </div>
            <div class="form-group">
                <label for="productImage">Image URL:</label>
                <input type="text" id="productImage" name="productImage" value="<?= htmlspecialchars($product['productImage']) ?>" required>
            </div>
            <div class="form-group">
                <label>Current Image:</label>
                <img src="<?= htmlspecialchars($product['productImage']) ?>" alt="Product Image" style="max-width: 200px; border-radius: 10px;">
            </div>
            <div class="form-group">
                <label for="productCategory">Category:</label>
                <select id="productCategory" name="productCategory" required>
                    <option value="makeup" <?= $product['productCategory'] === 'makeup' ? 'selected' : '' ?>>Makeup</option>
                    <option value="skincare" <?= $product['productCategory'] === 'skincare' ? 'selected' : '' ?>>Skincare</option>
                    <option value="fragrance" <?= $product['productCategory'] === 'fragrance' ? 'selected' : '' ?>>Fragrance</option>
                    <option value="haircare" <?= $product['productCategory'] === 'haircare' ? 'selected' : '' ?>>Haircare</option>
                    <option value="tools" <?= $product['productCategory'] === 'tools' ? 'selected' : '' ?>>Tools</option>
                </select>
            </div>
            <div class="form-group">
                <label for="productBrand">Brand:</label>
                <input type="text" id="productBrand" name="productBrand" value="<?= htmlspecialchars($product['productBrand']) ?>" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='delete_update_products_form.php'">Back to Manage Products</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back to Home</button>
            </div>
        </form>
    </div>
</body>
</html>
