import { IProduct } from '@/shared/model/product.model';
import { Component, Vue, Inject } from 'vue-property-decorator';
import ProductService from './product.service';
import AlertService from '@/shared/alert/alert.service';
import CatalogService from '../catalog/catalog.service';
import { ICatalog } from '@/shared/model/catalog.model';
import Swal from 'sweetalert2';
import { IHistory } from '@/shared/model/history.model';
import axios from 'axios';
import { HISTORY_BY_PRODUCT_ID } from '@/Urls';
import moment from 'moment';

@Component
export default class ProductComponent extends Vue {

    @Inject('productService') private productService: () => ProductService;
    @Inject('alertService') private alertService: () => AlertService;
    @Inject('catalogService') private catalogService: () => CatalogService;

    public isFetching = false;

    public itemsPerPage = 5;
    public queryCount: number = null;
    public page = 1;
    public previousPage = 1;
    public propOrder = 'id';
    public reverse = false;
    public totalItems = 0;

    public filterKeySelected = 'category';
    public searchStringValue = null;
    private removeId: number = null;
    public filterByStockEnabled = true;

    // crear y editar catalogo
    public createdTitleModal = '';
    public product: any = {
        serial_code: null,
        name: null,
        description: null,
        price: 10,
        iva: 15,
        discount: 0,
        resource_id: "",
        stock: 0,
        status: true,
        catalog_id: null,
        catalog: {
            id: null
        }
    };

    public products: IProduct[] = [];

    public catalogs: ICatalog[] = [];

    public historys: IHistory[] = [];

    public mounted(): void {
        console.log("ProductComponent::mounted");
        this.retrieveAll();
    }

    public handleSyncList(): void {
        this.clear();
    }

    public clear(): void {
        this.retrieveAll();
    }

    public retrieveAll(): void {
        this.isFetching = true;
        this.productService()
            .retrieve({
                page: this.page,
                size: this.itemsPerPage,
                sort: this.sort(),
            })
            .then(
                res => {
                    this.products = res.data.data;
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

    public sort(): any {
        const result = [this.propOrder + ',' + (this.reverse ? 'desc' : 'asc')];
        if (this.propOrder !== 'id') {
            result.push('id');
        }
        return result;
    }

    public loadPage(page: number): void {
        if (page !== this.previousPage) {
            this.previousPage = page;
            this.transition();
        }
    }

    public transition(): void {
        this.retrieveAll();
    }

    public onRegister(): void {

        this.createdTitleModal = 'Crear Producto';

        this.removeId = null;
        this.product = {};

        this.retrieveAllCatalogs();

        if (<any>this.$refs.createdEditEntity) {
            (<any>this.$refs.createdEditEntity).show();
        }

    }

    public onSearch(): void {
        this.isFetching = true;
        this.productService()
            .search({
                page: this.page,
                size: this.itemsPerPage,
                sort: this.sort(),
                key: this.filterKeySelected,
                value: this.searchStringValue
            })
            .then(
                res => {
                    this.products = res.data.data;
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

    public onEdit(product: IProduct): void {

        this.createdTitleModal = 'Editar Producto';

        this.removeId = product.id;
        this.product = product;

        this.retrieveAllCatalogs();

        if (<any>this.$refs.createdEditEntity) {
            (<any>this.$refs.createdEditEntity).show();
        }
    }

    public onPrepareRemove(product: IProduct): void {

        this.removeId = product.id;
        this.product = product;

        if (<any>this.$refs.removeEntity) {
            (<any>this.$refs.removeEntity).show();
        }
    }

    public closeDialog(): void {
        (<any>this.$refs.removeEntity).hide();
        (<any>this.$refs.createdEditEntity).hide();
        (<any>this.$refs.historyEntity).hide();
        (<any>this.$refs.settingEntity).hide();
    }

    public onRemove(): void {
        this.productService()
            .delete(this.removeId)
            .then(() => {
                const message = 'A Product is deleted with identifier ' + this.removeId;
                this.$bvToast.toast(message.toString(), {
                    toaster: 'b-toaster-top-center',
                    title: 'Info',
                    variant: 'danger',
                    solid: true,
                    autoHideDelay: 5000,
                });

                this.removeId = null;
                this.product = {};

                this.retrieveAll();
                this.closeDialog();
            })
            .catch(error => {
                this.alertService().showHttpError(this, error.response);
            });
    }

    public onHistory(product: IProduct): void {

        this.product = product;

        this.retrieveAllHistoryByProductId(product.id);

        if (<any>this.$refs.historyEntity) {
            (<any>this.$refs.historyEntity).show();
        }
    }

    public onSave(): void {

        var data = {
            serial_code: this.product.serial_code,
            name: this.product.name,
            description: this.product.description,
            price: this.product.price,
            iva: this.product.iva,
            discount: this.product.discount,
            resource_id: "",
            stock: this.product.stock,
            status: true,
            catalog_id: this.product.catalog_id
        };

        if (this.product.id) {
            this.productService()
                .update({
                    id: this.product.id,
                    ...data
                })
                .then(() => {
                    Swal.fire("Bien Hecho!", "Actualizamos el Producto correctamente!", "success");
                    this.retrieveAllCatalogs();
                    this.closeDialog();
                })
                .catch(error => {
                    this.alertService().showHttpError(this, error.response);
                });
        } else {
            this.productService()
                .create(data)
                .then(() => {
                    Swal.fire("Bien Hecho!", "Registramos el Producto correctamente!", "success");
                    this.retrieveAllCatalogs();
                    this.closeDialog();
                })
                .catch(error => {
                    this.alertService().showHttpError(this, error.response);
                });
        }

    }

    public onSetting(): void {

        if (<any>this.$refs.settingEntity) {
            (<any>this.$refs.settingEntity).show();
        }
    }

    public retrieveAllCatalogs(): void {
        this.catalogService()
            .retrieve({
                page: 1,
                size: 100,
                sort: this.sort(),
            })
            .then(
                res => {
                    this.catalogs = res.data.data;
                },
                err => {
                    this.alertService().showHttpError(this, err.response);
                }
            );
    }

    public retrieveAllHistoryByProductId(productId: number): void {

        axios
            .get(HISTORY_BY_PRODUCT_ID(productId))
            .then(res => {
                this.historys = res.data.data;
            })
            .catch(err => {
                this.alertService().showHttpError(this, err.response);
            });
    }

    public formatDate = (dateString: string, format: string) => {
        return moment(dateString).format(format);
    }

    public obtenerCambios(jsonA: any, jsonB: any) {
        const cambios = {};
        jsonA = JSON.parse(jsonA);
        jsonB = JSON.parse(jsonB);
    
        // Comparar cada atributo de jsonA con jsonB
        for (const key in jsonA) {
            if (jsonA.hasOwnProperty(key) && jsonB.hasOwnProperty(key)) {
                // Si los valores son diferentes, agregar al objeto de cambios
                if (jsonA[key] !== jsonB[key]) {
                    cambios[key] = jsonB[key];
                }
            }
        }
    
        return cambios;
    }
    
}