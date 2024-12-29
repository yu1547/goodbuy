<?php
$category = isset($_GET['category']) ? $_GET['category'] : '';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'check_brand') {
    $brand_name = $_POST['brand_name'];
    $servername = "localhost";
    $username = "root";
    $password = "123456789";
    $dbname = "good";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die(json_encode(["error" => "Database connection failed."]));
    }

    $stmt = $conn->prepare("SELECT country FROM brands WHERE brand_name = ?");
    $stmt->bind_param("s", $brand_name);
    $stmt->execute();
    $stmt->bind_result($country);
    if ($stmt->fetch()) {
        echo json_encode(["exists" => true, "country" => $country]);
    } else {
        echo json_encode(["exists" => false]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

// 連接資料庫
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "good";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 確認是否為 POST 請求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // 提示操作結果並返回主頁面
    echo "<script>alert('新增成功！'); window.location.href = 'product.php';</script>";
} else {
    // 非 POST 請求的錯誤處理
    echo "無效的請求！";
}

$conn->close();
?>
