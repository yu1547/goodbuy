<?php
include 'db.php';

// 處理搜尋
$searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

$sql = "SELECT p.product_id, p.product_name, p.category_name, p.price, p.description, 
               p.brand_name, b.country AS brand_country, b.website AS brand_website, 
               i.quantity AS stock_quantity
        FROM products p
        LEFT JOIN brands b ON p.brand_name = b.brand_name
        LEFT JOIN inventory i ON p.product_id = i.product_id";

if ($searchTerm) {
    $sql .= " WHERE p.product_name LIKE ? OR p.description LIKE ? OR p.category_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTermWildcard = "%" . $searchTerm . "%";
    $stmt->bind_param("sss", $searchTermWildcard, $searchTermWildcard, $searchTermWildcard);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
