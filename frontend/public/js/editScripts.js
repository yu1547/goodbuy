$category = isset($_GET['category']) ? $_GET['category'] : '';


$(document).ready(function () {
    $('input[name="brand_name"]').on('input', function () {
        const brandName = $(this).val();
        if (brandName.trim() !== "") {
            $.ajax({
                url: 'api/add_save.php',
                method: 'POST',
                data: { action: 'check_brand', brand_name: brandName },
                success: function (response) {
                    const result = JSON.parse(response);
                    const brandCountryInput = $('input[name="brand_country"]');
                    if (result.exists) {
                        brandCountryInput.val(result.country).prop('disabled', true);
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
});
