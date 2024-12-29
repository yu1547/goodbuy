<?php
// 連接資料庫
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "good";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 獲取搜尋分類參數
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql = "SELECT p.product_id, p.product_name, p.category_name, p.price, p.description, 
               p.brand_name, b.country AS brand_country, i.quantity AS stock_quantity
        FROM products p
        LEFT JOIN brands b ON p.brand_name = b.brand_name
        LEFT JOIN inventory i ON p.product_id = i.product_id";

if ($category) {
    $sql .= " WHERE p.category_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

// 回傳查詢結果
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['product_id']) . "</td>
                <td>" . htmlspecialchars($row['product_name']) . "</td>
                <td>" . htmlspecialchars($row['category_name']) . "</td>
                <td>" . htmlspecialchars($row['brand_name']) . "</td>
                <td>" . htmlspecialchars($row['price']) . "</td>
                <td>" . htmlspecialchars($row['description']) . "</td>
                <td>" . htmlspecialchars($row['stock_quantity']) . "</td>
                <td>
                    <a href='edit_product.php?product_id=" . $row['product_id'] . "'>
                        <button class='btn btn-edit'>修改</button>
                    </a>
                </td>
                <td>
                    <button class='btn btn-delete' onclick='deleteProduct(" . $row['product_id'] . ")'>刪除</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>沒有找到符合條件的商品。</td></tr>";
}

$conn->close();
?>
