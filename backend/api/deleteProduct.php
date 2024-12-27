<?php
include 'db.php';


// 接收 POST 請求的 product_id
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    // 檢查產品是否存在
    $check_sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 刪除產品
        $delete_sql = "DELETE FROM products WHERE product_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $product_id);

        if ($delete_stmt->execute()) {
            echo "success";
        } else {
            echo "刪除失敗：" . $conn->error;
        }
    } else {
        echo "產品不存在";
    }
} else {
    echo "無效的請求";
}

$conn->close();
?>

