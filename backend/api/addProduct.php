<?php
// 引入資料庫連接檔案
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $category_name = $_POST['category_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $brand_name = $_POST['brand_name'];
    $quantity = $_POST['quantity'];

    // 檢查品牌是否存在
    $checkBrand = "SELECT * FROM brands WHERE brand_name = '$brand_name'";
    $brandResult = mysqli_query($conn, $checkBrand);

    if (mysqli_num_rows($brandResult) > 0) {
        // 新增商品資訊
        $addProduct = "INSERT INTO products (product_name, category_name, price, description, brand_name) VALUES ('$product_name', '$category_name', $price, '$description', '$brand_name')";
        
        if (mysqli_query($conn, $addProduct)) {
            // 獲取新商品的 ID
            $product_id = mysqli_insert_id($conn);

            // 新增庫存數量
            $addInventory = "INSERT INTO inventory (product_id, quantity) VALUES ($product_id, $quantity)";
            
            if (mysqli_query($conn, $addInventory)) {
                echo "success";
            } else {
                echo "庫存新增失敗：" . mysqli_error($conn);
            }
        } else {
            echo "產品新增失敗：" . mysqli_error($conn);
        }
    } else {
        echo "該品牌不存在，請先新增品牌";
    }
} else {
    echo "無效的請求方法";
}

$conn->close();
?>
