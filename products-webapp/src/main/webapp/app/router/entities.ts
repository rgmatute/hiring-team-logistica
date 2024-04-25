import { Authority } from '@/shared/security/authority';
/* tslint:disable */
// prettier-ignore
const Entities = () => import('@/entities/entities.vue');

import Catalog from '@/entities/catalog/catalog.vue';
import Product from '@/entities/product/product.vue';

// jhipster-needle-add-entity-to-router-import - JHipster will import entities to the router here

// export default {
//   path: '/',
//   component: Entities,
//   children: [
//     // jhipster-needle-add-entity-to-router - JHipster will add entities to the router here
//   ],
// };

export default [
  {
    path: '/admin/catalogs',
    name: 'Catalog',
    component: Catalog,
    meta: { authorities: [Authority.ADMIN, Authority.USER] },
  },
  {
    path: '/admin/products',
    name: 'Product',
    component: Product,
    meta: { authorities: [Authority.ADMIN, Authority.USER] },
  }
]