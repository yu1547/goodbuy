$(document).ready(function() {
    // 商品總覽按鈕跳轉
    $('#productOverviewButton').click(function() {
        window.location.href = 'product.html';
    });

    // 買家預覽按鈕跳轉
    $('#buyerPreviewButton').click(function() {
        window.location.href = 'buyer.html';
    });

    // 表單提交處理
    $('#productForm').submit(function(event) {
        event.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: 'backend/api/addProduct.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === 'success') {
                    alert('新增成功！');
                    window.location.href = 'product.html';
                } else {
                    alert('新增失敗：' + response);
                }
            },
            error: function(xhr, status, error) {
                console.error('There was an error adding the product!', error);
            }
        });
    });
});
