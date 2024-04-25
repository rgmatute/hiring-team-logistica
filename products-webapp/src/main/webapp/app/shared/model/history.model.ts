export interface IHistory {
    id?: number;
    product_id?: string | null;
    controller?: string | null;
    method?: string | null;
    event?: string | null;
    before?: string | null;
    after?: string | null;
    created_by?: string | null;
    last_modified_by?: string | null;
    created_at?: string | null;
    updated_at?: string | null;
  }
  
  export class History implements IHistory {
    constructor(
      id?: number,
      product_id?: string | null,
      controller?: string | null,
      method?: string | null,
      event?: string | null,
      before?: string | null,
      after?: string | null,
      created_by?: string | null,
      last_modified_by?: string | null,
      created_at?: string | null,
      updated_at?: string | null,
      status?: boolean | null
    ) {}
  }
  