<?php
include 'db.php';

try {
    $query = "INSERT INTO `products` VALUES ('4', '慢跑鞋', '鞋類', 'PUMA', '2100', '好穿', current_timestamp())";
    $stmt = $conn->prepare($query); // 準備 SQL 語法
    $stmt->execute(); // 執行 SQL
    echo "Success";
} catch (Exception $e) { // 捕捉一般 Exception
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
