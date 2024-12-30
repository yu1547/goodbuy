<?php
// 引入資料庫連接檔案
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category_name = $_POST['category_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $brand_name = $_POST['brand_name'];
    $quantity = $_POST['quantity'];

    // 更新商品資訊
    $updateProduct = "UPDATE products SET 
        product_name = '$product_name', 
        category_name = '$category_name', 
        price = $price, 
        description = '$description',
        brand_name = '$brand_name'
        WHERE product_id = $product_id";

    if (mysqli_query($conn, $updateProduct)) {
        // 更新庫存數量
        $updateInventory = "UPDATE inventory SET quantity = $quantity WHERE product_id = $product_id";

        if (mysqli_query($conn, $updateInventory)) {
            echo "success";
        } else {
            echo "庫存更新失敗：" . mysqli_error($conn);
        }
    } else {
        echo "產品更新失敗：" . mysqli_error($conn);
    }
} else {
    echo "無效的請求方法";
}

$conn->close();
?>
