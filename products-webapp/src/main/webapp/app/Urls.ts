export const BASE_URL = `http://127.0.0.1:1902`; //dev

export const API_LOGIN = `api/v1/account/authenticate`;

export const CATALOGOS = `api/v1/catalogs`;
export const PRODUCTOS = `api/v1/products`;

export const HISTORY_BY_PRODUCT_ID = (productId: number) => `api/v1/history/search?key=product_id&value=${productId}`;
