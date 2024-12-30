import axios from 'axios';

const API_BASE_URL = '/backend/api';

export const getProducts = (searchTerm = '') => {
  return axios.get(`${API_BASE_URL}/getProducts.php`, {
    params: { searchTerm }
  });
};

export const deleteProduct = (productId) => {
    return axios.post(`${API_BASE_URL}/delSave.php`, { product_id: productId });
};


// 獲取商品詳細資料 API
export const getProductDetails = (productId) => {
    return axios.get(`${API_BASE_URL}/getProductDetails.php`, {
        params: { product_id: productId }
    });
};

// 更新商品 API
export const updateProduct = (productData) => {
    return axios.post(`${API_BASE_URL}/updateSave.php`, productData);
};

// 新增商品 API
export const addProduct = (productData) => {
    return axios.post(`${API_BASE_URL}/addProduct.php`, productData);
};
