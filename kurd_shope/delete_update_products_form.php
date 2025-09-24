<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Manage Products</h1>
        <table class="product-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include database connection
                include 'connection.php';
                $query = "SELECT * FROM products";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['productName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['productCategory']) . "</td>";
                        echo "<td>" . number_format($row['productPrice']) . " د.ع</td>";
                        echo "<td><img src='" . htmlspecialchars($row['productImage']) . "' alt='Product Image' style='max-width:80px;max-height:80px;border-radius:8px;'></td>";
                        echo "<td>
                                <form method='POST' action='delete_product.php' style='display:inline-block;'>
                                    <input type='hidden' name='productId' value='" . htmlspecialchars($row['id']) . "'>
                                    <button type='submit' class='btn btn-primary'>Delete</button>
                                </form>
                                <form method='POST' action='edit_product_form.php' style='display:inline-block;'>
                                    <input type='hidden' name='productId' value='" . htmlspecialchars($row['id']) . "'>
                                    <button type='submit' class='btn btn-primary'>Edit</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No products found.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    
    <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.location.href='add_data_form.php'">Back to adding Products</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back to Home</button>
            </div>
</body>
</html>
