$(document).ready(function() {
    var productId = 1; // 你可以根據需要設置初始 product_id

    // 使用 AJAX 請求來獲取商品數據
    $.ajax({
        url: 'http://localhost/backend/api/getProduct.php',
        type: 'GET',
        data: { product_id: productId },
        success: function(response) {
            var product = JSON.parse(response);
            if (!product.error) {
                $('#product_id').val(product.product_id);
                $('#product_name').val(product.product_name);
                $('#category_name').val(product.category_name);
                $('#price').val(product.price);
                $('#description').val(product.description);
                $('#brand_name').val(product.brand_name);
                $('#quantity').val(product.quantity);
            } else {
                alert(product.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('There was an error fetching product data!', error);
        }
    });

    // 使用 AJAX 請求來提交表單數據
    $('#productForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: 'http://localhost/backend/api/updateSave.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                alert('商品更新成功！');
            },
            error: function(xhr, status, error) {
                console.error('There was an error updating the product!', error);
            }
        });
    });
});
