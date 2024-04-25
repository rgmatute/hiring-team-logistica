
import AlertService from '@/shared/alert/alert.service';
import { ICatalog } from '@/shared/model/catalog.model';
import { Component, Vue, Inject } from 'vue-property-decorator';
import CatalogService from './catalog.service';
import Catalog from './catalog.vue';
import Swal from 'sweetalert2';

@Component
export default class CatalogComponent extends Vue {

    @Inject('catalogService') private catalogService: () => CatalogService;
    @Inject('alertService') private alertService: () => AlertService;

    public isFetching = false;

    public itemsPerPage = 5;
    public queryCount: number = null;
    public page = 1;
    public previousPage = 1;
    public propOrder = 'id';
    public reverse = false;
    public totalItems = 0;

    public searchStringValue = null;
    private removeId: number = null;


    public catalogs: ICatalog[] = [];

    // crear y editar catalogo
    public createdTitleModal = '';
    public catalog: any = {
        id: null,
        catalog_key: null,
        item_name: null,
        catalog_name: null,
        catalog_description: null,
        status: true
      };
    

    public mounted(): void {
        this.retrieveAllCatalogs();
        console.log("CatalogComponent::mounted");
    }

    public handleSyncList(): void {
        this.clear();
    }

    public clear(): void {
        this.retrieveAllCatalogs();
    }

    public retrieveAllCatalogs(): void {
        this.isFetching = true;
        this.catalogService()
            .retrieve({
                page: this.page,
                size: this.itemsPerPage,
                sort: this.sort(),
            })
            .then(
                res => {
                    this.catalogs = res.data.data;
                    this.isFetching = false;

                    // this.totalItems = Number(res.headers['x-total-count']);
                    this.totalItems = res.data.total;
                    this.queryCount = this.totalItems;
                },
                err => {
                    this.isFetching = false;
                    this.alertService().showHttpError(this, err.response);
                }
            );
    }

    public transition(): void {
        this.retrieveAllCatalogs();
    }

    public changeOrder(propOrder: string): void {
        this.propOrder = propOrder;
        this.reverse = !this.reverse;
        this.transition();
    }

    public sort(): any {
        const result = [this.propOrder + ',' + (this.reverse ? 'desc' : 'asc')];
        if (this.propOrder !== 'id') {
            result.push('id');
        }
        return result;
    }

    public loadPage(page: number): void {
        console.log("aaaaaaaaaaaa", page, this.previousPage)
        if (page !== this.previousPage) {
            this.previousPage = page;
            this.transition();
        }
    }

    public searchCatalogs(): void {
        this.isFetching = true;
        this.catalogService()
            .search({
                page: this.page,
                size: this.itemsPerPage,
                sort: this.sort(),
                key: 'catalog_name',
                value: this.searchStringValue
            })
            .then(
                res => {
                    this.catalogs = res.data.data;
                    this.isFetching = false;
                    this.totalItems = res.data.total;
                    this.queryCount = this.totalItems;
                },
                err => {
                    this.isFetching = false;
                    this.alertService().showHttpError(this, err.response);
                }
            );
    }

    public prepareRemove(instance: ICatalog): void {
        this.removeId = instance.id;
        if (<any>this.$refs.removeEntity) {
            (<any>this.$refs.removeEntity).show();
        }
    }

    public closeDialog(): void {
        (<any>this.$refs.removeEntity).hide();
        (<any>this.$refs.createdEditEntity).hide();
    }

    public removeCatalog(): void {
        this.catalogService()
          .delete(this.removeId)
          .then(() => {
            const message = 'A Catalog is deleted with identifier ' + this.removeId;
            this.$bvToast.toast(message.toString(), {
              toaster: 'b-toaster-top-center',
              title: 'Info',
              variant: 'danger',
              solid: true,
              autoHideDelay: 5000,
            });
            this.removeId = null;
            this.retrieveAllCatalogs();
            this.closeDialog();
          })
          .catch(error => {
            this.alertService().showHttpError(this, error.response);
          });
      }
        
    public registerCatalog (): void {
        this.createdTitleModal = 'Crear Catalogo';

        this.catalog = [];

        if (<any>this.$refs.createdEditEntity) {
            (<any>this.$refs.createdEditEntity).show();
        }
    }

    public editCatalog (catalog: ICatalog): void {
        this.createdTitleModal = 'Editar Catalogo';
        
        this.catalog = catalog

        if (<any>this.$refs.createdEditEntity) {
            (<any>this.$refs.createdEditEntity).show();
        }
    }

    public saveCatalog(): void {

        if(this.catalog.id) {
            this.catalogService()
            .update({
                id: this.catalog.id,
                item_name: this.catalog.catalog_name,
                catalog_name: this.catalog.catalog_name,
                catalog_description: this.catalog.catalog_description
            })
            .then(() => {
                Swal.fire("Bien Hecho!", "Actualizamos el catálogo correctamente!", "success");
                this.retrieveAllCatalogs();
                this.closeDialog();
            })
            .catch(error => {
                this.alertService().showHttpError(this, error.response);
            });
        }else {
            this.catalogService()
            .create({
                catalog_key: this.catalog.catalog_key,
                item_name: this.catalog.catalog_name,
                catalog_name: this.catalog.catalog_name,
                catalog_description: this.catalog.catalog_description
            })
            .then(() => {
                Swal.fire("Bien Hecho!", "Registramos el catálogo correctamente!", "success");
                this.retrieveAllCatalogs();
                this.closeDialog();
            })
            .catch(error => {
                this.alertService().showHttpError(this, error.response);
            });
        }
    }


}