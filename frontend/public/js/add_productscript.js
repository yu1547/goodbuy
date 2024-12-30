import { checkBrandName, addProduct } from './api.js';

$(document).ready(function () {
    $('input[name="brand_name"]').on('input', function () {
        const brandName = $(this).val();
        if (brandName.trim() !== "") {
            // 使用 $.ajax 調用檢查品牌名稱 API
            $.ajax({
                url: '/backend/api/check_brand.php',
                method: 'POST',
                data: { brand_name: brandName },
                success: function (response) {
                    const brandCountryInput = $('input[name="brand_country"]');
                    if (response.exists) {
                        brandCountryInput.val(response.country).prop('disabled', true);
                    } else {
                        brandCountryInput.val('').prop('disabled', false);
                    }
                },
                error: function () {
                    alert("無法檢查品牌資料。請稍後重試。");
                },
            });
        } else {
            $('input[name="brand_country"]').val('').prop('disabled', false);
        }
    });

    $('#productForm').on('submit', function (event) {
        event.preventDefault(); // 防止表單默認提交

        const formData = $(this).serialize();

        // 使用 $.ajax 調用新增商品 API
        $.ajax({
            url: '/backend/api/add_product.php',
            method: 'POST',
            data: formData,
            success: function () {
                alert('新增成功！');
                window.location.href = 'product.html'; // 跳轉到商品頁面
            },
            error: function () {
                alert("新增失敗。請稍後重試。");
            },
        });
    });
});
