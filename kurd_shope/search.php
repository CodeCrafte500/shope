<?php
// search.php
include 'kurd_shop'; // Include your database connection

if (isset($_GET['query'])) {
    $query = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT * FROM products WHERE productName LIKE '%$query%' OR productNameEn LIKE '%$query%'";
    $result = $conn->query($sql);

    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    echo json_encode($products); // Return the results as JSON
}
$conn->close();
?>
