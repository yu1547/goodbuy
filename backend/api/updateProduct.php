<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.00;
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $brand_name = isset($_POST['brand_name']) ? $_POST['brand_name'] : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    if ($product_id) {
        // 更新產品資料
        $update_sql = "UPDATE products SET product_name = ?, category_name = ?, price = ?, description = ?, brand_name = ? WHERE product_id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssdsii", $product_name, $category_name, $price, $description, $brand_name, $product_id);

        if ($stmt->execute()) {
            // 更新庫存
            $inventory_sql = "UPDATE inventory SET quantity = ? WHERE product_id = ?";
            $inventory_stmt = $conn->prepare($inventory_sql);
            $inventory_stmt->bind_param("ii", $quantity, $product_id);

            if ($inventory_stmt->execute()) {
                echo "success";
            } else {
                echo "庫存更新失敗：" . $conn->error;
            }
            $inventory_stmt->close();
        } else {
            echo "產品更新失敗：" . $conn->error;
        }
        $stmt->close();
    } else {
        echo "無效的商品 ID";
    }
} else {
    echo "無效的請求方法";
}

$conn->close();
?>
