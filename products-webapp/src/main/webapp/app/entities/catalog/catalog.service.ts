import axios from 'axios';
import {CATALOGOS} from '@/Urls';
import buildPaginationQueryOpts from "@/shared/sort/sorts";
import { ICatalog } from '@/shared/model/catalog.model';
import {buildPaginationQueryOptsUtils} from '@/Utils';

const baseApiUrl = 'api/products';

export default class CatalogService {

  public find(id: number): Promise<ICatalog> {
    return new Promise<ICatalog>((resolve, reject) => {
      axios
        .get(`${CATALOGOS}/${id}`)
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
        .get(`${CATALOGOS}?${buildPaginationQueryOpts(req)}`)
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
        .delete(`${CATALOGOS}/${id}`)
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
        .post(`${CATALOGOS}`, entity)
        .then(res => {
          resolve(res.data);
        })
        .catch(err => {
          reject(err);
        });
    });
  }

  public update(entity: ICatalog): Promise<any> {
    return new Promise<any>((resolve, reject) => {
      axios
        .put(`${CATALOGOS}/${entity.id}`, entity)
        .then(res => {
          resolve(res.data);
        })
        .catch(err => {
          reject(err);
        });
    });
  }

  public partialUpdate(entity: ICatalog): Promise<ICatalog> {
    return new Promise<ICatalog>((resolve, reject) => {
      axios
        .patch(`${CATALOGOS}/${entity.id}`, entity)
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
        .get(`${CATALOGOS}/search?${buildPaginationQueryOptsUtils(req)}`)
        .then(res => {
          resolve(res);
        })
        .catch(err => {
          reject(err);
        });
    });
  }
}
