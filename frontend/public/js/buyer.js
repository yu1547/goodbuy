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
                console.log('API Response:', response); // 新增這一行用於調試
                var products = JSON.parse(response);
                var productTableBody = $('#buyerTableBody');

                productTableBody.empty(); // 清空商品表格內容
                if (products.length > 0) {
                    $.each(products, function(index, product) {
                        var row = '<tr>' +
                                  '<td>' + product.product_id + '</td>' +
                                  '<td>' + product.product_name + '</td>' +
                                  '<td>' + product.category_name + '</td>' +
                                  '<td><a class="link" href="' + product.brand_website + '" target="_blank">' + product.brand_name + '</a></td>' +
                                  '<td>' + product.brand_country + '</td>' +
                                  '<td>' + product.price + '</td>' +
                                  '<td>' + product.description + '</td>' +
                                  '<td>' + product.stock_quantity + '</td>' +
                                  '</tr>';
                        productTableBody.append(row);
                    });
                } else {
                    var noResultRow = '<tr><td colspan="8">找不到符合條件的商品</td></tr>';
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
