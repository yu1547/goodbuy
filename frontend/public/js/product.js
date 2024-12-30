$(document).ready(function() {
    // 商品總覽按鈕跳轉
    $('#productOverviewButton').click(function() {
        window.location.href = 'product.html';
    });

    // 買家預覽按鈕跳轉
    $('#buyerPreviewButton').click(function() {
        window.location.href = 'buyer.html';
    });

    // 請求商品數據並顯示在頁面上
    function loadProductList(searchTerm = '') {
        $.ajax({
            url: 'backend/api/getProducts.php', // 確保這個路徑正確
            type: 'GET',
            data: { searchTerm: searchTerm },
            success: function(response) {
                var products = JSON.parse(response);
                var productTableBody = $('#productTableBody');

                productTableBody.empty(); // 清空商品表格內容
                if (products.length > 0) {
                    $.each(products, function(index, product) {
                        var row = '<tr id="product-row-' + product.product_id + '">' +
                                  '<td>' + product.product_id + '</td>' +
                                  '<td>' + product.product_name + '</td>' +
                                  '<td>' + product.category_name + '</td>' +
                                  '<td>' + product.brand_name + '</td>' +
                                  '<td>' + product.price + '</td>' +
                                  '<td>' + product.description + '</td>' +
                                  '<td>' + product.stock_quantity + '</td>' +
                                  '<td><button class="btn btn-edit" onclick="editProduct(' + product.product_id + ')">修改</button></td>' +
                                  '<td><button class="btn btn-delete" onclick="deleteProduct(' + product.product_id + ')">刪除</button></td>' +
                                  '</tr>';
                        productTableBody.append(row);
                    });
                } else {
                    var noResultRow = '<tr><td colspan="9">找不到符合條件的商品</td></tr>';
                    productTableBody.append(noResultRow);
                }
            },
            error: function(xhr, status, error) {
                console.error('There was an error fetching product data!', error);
            }
        });
    }

    // 初始加載商品列表
    loadProductList();

    // 搜尋按鈕點擊事件
    $('#searchButton').click(function() {
        var searchTerm = $('#searchInput').val();
        loadProductList(searchTerm);
    });
});

function deleteProduct(productId) {
    if (confirm("確定要刪除此商品嗎？")) {
        $.ajax({
            url: 'backend/api/delSave.php',
            type: 'POST',
            data: { product_id: productId },
            success: function(response) {
                if (response.trim() === "success") {
                    // 刪除成功，從頁面移除該列
                    $('#product-row-' + productId).remove();
                    alert("刪除成功！");
                } else {
                    alert("刪除失敗：" + response);
                }
            },
            error: function(xhr, status, error) {
                console.error('There was an error deleting product!', error);
            }
        });
    }
}

function editProduct(productId) {
    window.location.href = 'edit.html?product_id=' + productId;
}
