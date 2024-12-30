$(document).ready(function() {
    // 商品總覽按鈕跳轉
    $('#productOverviewButton').click(function() {
        window.location.href = 'product.html';
    });

    // 買家預覽按鈕跳轉
    $('#buyerPreviewButton').click(function() {
        window.location.href = 'buyer.html';
    });
    
    // 獲取 URL 中的 product_id
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('product_id');

    if (!productId) {
        alert('未指定商品 ID');
        window.location.href = 'product.html';
    }

    // 請求商品資料並填充表單
    function loadProductDetails() {
        $.ajax({
            url: 'backend/api/getProductDetails.php',
            type: 'GET',
            data: { product_id: productId },
            success: function(response) {
                const product = JSON.parse(response);

                if (product) {
                    $('#product_id').val(product.product_id);
                    $('#product_name').val(product.product_name);
                    $('#category_name').val(product.category_name);
                    $('#price').val(product.price);
                    $('#description').val(product.description);
                    $('#brand_name').val(product.brand_name);
                    $('#quantity').val(product.quantity);
                } else {
                    alert('找不到指定的商品 ID');
                    window.location.href = 'product.html';
                }
            },
            error: function(xhr, status, error) {
                console.error('There was an error fetching product details!', error);
            }
        });
    }

    // 加載商品詳細資料
    loadProductDetails();

    // 表單提交處理
    $('#productForm').submit(function(event) {
        event.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: 'backend/api/updateSave.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === 'success') {
                    alert('更新成功！');
                    window.location.href = 'product.html';
                } else {
                    alert('更新失敗：' + response);
                }
            },
            error: function(xhr, status, error) {
                console.error('There was an error updating the product!', error);
            }
        });
    });
});
