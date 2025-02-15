<?php
header("Content-Type: application/json");

include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $category_name = $_POST['category_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $brand_name = $_POST['brand_name'];
    $brand_country = $_POST['brand_country'];
    $quantity = $_POST['quantity'];

    // 插入品牌資料（如果品牌不存在）
    $brand_sql = "INSERT IGNORE INTO brands (brand_name, country) VALUES (?, ?)";
    $stmt = $conn->prepare($brand_sql);
    $stmt->bind_param("ss", $brand_name, $brand_country);
    $stmt->execute();

    // 插入商品資料
    $product_sql = "INSERT INTO products (product_name, category_name, price, description, brand_name) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($product_sql);
    $stmt->bind_param("ssdss", $product_name, $category_name, $price, $description, $brand_name);
    $stmt->execute();

    // 獲取新增的商品 ID 並插入庫存資料
    $product_id = $conn->insert_id;
    $inventory_sql = "INSERT INTO inventory (product_id, quantity) VALUES (?, ?)";
    $stmt = $conn->prepare($inventory_sql);
    $stmt->bind_param("ii", $product_id, $quantity);
    $stmt->execute();

    echo json_encode(['message' => '新增成功！']);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
}

$conn->close();
?>
