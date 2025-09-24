<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Add Product</h1>
        <form method="POST" action="add_data_product_code.php">
            <div class="form-group">
                <label for="productName">Product Name (Kurdish):</label>
                <input type="text" id="productName" name="productName" required>
            </div>
            <div class="form-group">
                <label for="productNameEn">Product Name (English):</label>
                <input type="text" id="productNameEn" name="productNameEn" required>
            </div>
            <div class="form-group">
                <label for="productDescription">Description:</label>
                <textarea id="productDescription" name="productDescription" required></textarea>
            </div>
            <div class="form-group">
                <label for="productPrice">Price:</label>
                <input type="number" id="productPrice" name="productPrice" required>
            </div>
            <div class="form-group">
                <label for="productOriginalPrice">Original Price:</label>
                <input type="number" id="productOriginalPrice" name="productOriginalPrice">
            </div>
            <div class="form-group">
                <label for="productImage">Image URL:</label>
                <input type="text" id="productImage" name="productImage" required>
            </div>
            <div class="form-group">
                <label for="productCategory">Category:</label>
                <select id="productCategory" name="productCategory" required>
                    <option value="makeup">Makeup</option>
                    <option value="skincare">Skincare</option>
                    <option value="fragrance">Fragrance</option>
                    <option value="haircare">Haircare</option>
                    <option value="tools">Tools</option>
                </select>
            </div>
            <div class="form-group">
                <label for="productBrand">Brand:</label>
                <input type="text" id="productBrand" name="productBrand" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Product</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back to Home</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='delete_update_products_form.php'">Manage Products</button>
            </div>
        </form>
    </div>
</body>
</html>