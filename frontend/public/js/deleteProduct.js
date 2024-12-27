// deleteProduct.js

export const deleteProduct = async (productId) => {
    try {
        const response = await fetch("http://localhost/backend/api/deleteProduct.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                product_id: productId,
            }),
        });

        const result = await response.text();
        return result;
    } catch (error) {
        console.error("刪除產品時發生錯誤: ", error);
        return "error";
    }
};
