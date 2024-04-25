import axios from 'axios';
import {PRODUCTOS} from '@/Urls';
import buildPaginationQueryOpts from "@/shared/sort/sorts";
import { IProduct } from '@/shared/model/product.model';
import {buildPaginationQueryOptsUtils} from '@/Utils';

export default class ProductService {

  public find(id: number): Promise<IProduct> {
    return new Promise<IProduct>((resolve, reject) => {
      axios
        .get(`${PRODUCTOS}/${id}`)
        .then(res => {
          resolve(res.data);
        })
        .catch(err => {
          reject(err);
        });
    });
  }

  public retrieve(req: any): Promise<any> {
    return new Promise<any>((resolve, reject) => {
      axios
        .get(`${PRODUCTOS}?${buildPaginationQueryOpts(req)}`)
        .then(res => {
          resolve(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  }

  public delete(id: number): Promise<any> {
    return new Promise<any>((resolve, reject) => {
      axios
        .delete(`${PRODUCTOS}/${id}`)
        .then(res => {
          resolve(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  }

  public create(entity: any): Promise<any> {
    console.log("create-", entity);
    return new Promise<any>((resolve, reject) => {
      axios
        .post(`${PRODUCTOS}`, entity)
        .then(res => {
          resolve(res.data);
        })
        .catch(err => {
          reject(err);
        });
    });
  }

  public update(entity: IProduct): Promise<any> {
    return new Promise<any>((resolve, reject) => {
      axios
        .put(`${PRODUCTOS}/${entity.id}`, entity)
        .then(res => {
          resolve(res.data);
        })
        .catch(err => {
          reject(err);
        });
    });
  }

  public partialUpdate(entity: IProduct): Promise<IProduct> {
    return new Promise<IProduct>((resolve, reject) => {
      axios
        .patch(`${PRODUCTOS}/${entity.id}`, entity)
        .then(res => {
          resolve(res.data);
        })
        .catch(err => {
          reject(err);
        });
    });
  }

  public search(req: any): Promise<any> {
    return new Promise<any>((resolve, reject) => {
      axios
        .get(`${PRODUCTOS}/search?${buildPaginationQueryOptsUtils(req)}`)
        .then(res => {
          resolve(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  }
}
