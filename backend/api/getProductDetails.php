<?php
include 'db.php';

if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    $sql = "SELECT p.*, i.quantity 
            FROM products p 
            LEFT JOIN inventory i ON p.product_id = i.product_id 
            WHERE p.product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }

    $stmt->close();
} else {
    echo json_encode(null);
}

$conn->close();
?>
