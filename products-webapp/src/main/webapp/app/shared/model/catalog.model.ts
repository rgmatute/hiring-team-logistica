export interface ICatalog {
    id?: number;
    item_name?: string | null;
    catalog_key?: string | null;
    catalog_name?: string | null;
    catalog_description?: string | null;
    created_by?: string | null;
    last_modified_by?: string | null;
    created_at?: string | null;
    updated_at?: string | null;
    status?: boolean | null;
  }
  
  export class Catalog implements ICatalog {
    constructor(
      id?: number,
      item_name?: string | null,
      catalog_key?: string | null,
      catalog_name?: string | null,
      catalog_description?: string | null,
      created_by?: string | null,
      last_modified_by?: string | null,
      created_at?: string | null,
      updated_at?: string | null,
      status?: boolean | null
    ) {}
  }
  