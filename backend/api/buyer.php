<?php
include 'db.php';

// 查詢商品資料
$sql = "SELECT p.product_id, p.product_name, p.category_name, p.price, p.description, 
               p.brand_name, b.country AS brand_country, b.website AS brand_website, 
               i.quantity AS stock_quantity
        FROM products p
        LEFT JOIN brands b ON p.brand_name = b.brand_name
        LEFT JOIN inventory i ON p.product_id = i.product_id";

$searchTerm = isset($_GET['category']) ? $_GET['category'] : ''; 
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

$category_count = 0;
if ($searchTerm) {
    $count_sql = "SELECT COUNT(*) AS total_count FROM products 
                  WHERE product_name LIKE ? OR description LIKE ? OR category_name LIKE ?";
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->bind_param("sss", $searchTermWildcard, $searchTermWildcard, $searchTermWildcard);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    if ($count_result->num_rows > 0) {
        $count_row = $count_result->fetch_assoc();
        $category_count = $count_row['total_count'];
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品資訊總覽</title>
    <link rel="stylesheet" href="css/buyer_styles.css">
    </script>
</head>
<body>
<div class="title">SUPER_GOOD</div>
<div class="navbar">
    <div class="home">
        <a href="index.php">
            <img src="home.png" alt="首頁圖示">
        </a>
        <a href="product.php">商品總覽</a>
        <a href="buyer.php">買家預覽</a> 
    </div>
    <div class="search-bar">
        <form method="GET" action="buyer.php">
            <input type="text" name="category" placeholder="搜尋商品名稱、分類、描述" value="<?= htmlspecialchars($searchTerm) ?>">
            <button>
                <img src="search.png" alt="搜尋圖示">
            </button>
        </form>
    </div>
</div>

<?php if ($searchTerm): ?>
    <div class="category-count" style="margin-left: 5%;">
        搜尋結果共有 <?= $category_count ?> 件商品
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>商品編號</th>
            <th>商品名稱</th>
            <th>分類</th>
            <th>品牌</th>
            <th>品牌國家</th>
            <th>價格</th>
            <th>描述</th>
            <th>庫存數量</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['product_id']) ?></td>
                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td>
                        <a class="link" href="<?= htmlspecialchars($row['brand_website']) ?>" target="_blank">
                            <?= htmlspecialchars($row['brand_name']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($row['brand_country']) ?></td>
                    <td><?= htmlspecialchars($row['price']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['stock_quantity']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">沒有找到符合條件的商品。</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php $conn->close(); ?>
</body>
</html>
