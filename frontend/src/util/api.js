import axios from 'axios';

const API_BASE_URL = 'http://localhost/backend/api';

export const getProduct = (productId) => {
  return axios.get(`${API_BASE_URL}/getProduct.php`, {
    params: {
      product_id: productId
    }
  });
};

export const updateProduct = (productData) => {
  return axios.post(`${API_BASE_URL}/updateSave.php`, productData);
};
