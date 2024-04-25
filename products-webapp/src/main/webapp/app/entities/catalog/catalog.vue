<template>
    <div :style="catalogs && catalogs.length === 0 ? 'height: 430px !important' : ''">
        <h2 id="page-heading" data-cy="CatalogHeading">
            <span id="catalogs-heading">Catalogs</span>
            <br>
            <div class="d-flex justify-content-end">
                <button class="btn btn-info mr-2" v-on:click="handleSyncList" :disabled="isFetching">
                    <font-awesome-icon icon="sync" :spin="isFetching"></font-awesome-icon> <span>Refrescar</span>
                </button>
                <!-- <router-link :to="{ name: 'CatalogCreate' }" custom v-slot="{ navigate }"> -->
                <button class="btn btn-primary ml-2" v-on:click="registerCatalog()">
                    <font-awesome-icon icon="plus"></font-awesome-icon> <span>Registrar Catalogo</span>
                </button>
                <!-- </router-link> -->
            </div>
        </h2>

        <br />
        <div class="alert alert-warning" v-if="!isFetching && catalogs && catalogs.length === 0">
            <span>No catalogs found</span>
        </div>

        <div class="d-flex justify-content-end" v-if="catalogs && catalogs.length > 0">
            <!-- buscador -->
            <b-form-group label="Search by name" class="mb-0">
                <b-input-group size="md" class="mb-2">
                    <b-form-input id="input-catalogs-search-value" v-model="searchStringValue"
                        v-on:keyup.enter="searchCatalogs()" placeholder="Enter your name"></b-form-input>
                    <b-input-group-append>
                        <b-button variant="primary" size="md" @click="searchCatalogs()">
                            <font-awesome-icon icon="search" class="small"></font-awesome-icon>
                            Search
                        </b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>
        </div>

        <div class="table-responsive" v-if="catalogs && catalogs.length > 0">
            <table class="table table-striped table-sm table-bordered" aria-describedby="catalogs">
                <thead class="text-center">
                    <tr>
                        <th scope="row"><span></span></th>
                        <th scope="row"><span>Code</span></th>
                        <th scope="row"><span>Catalog name</span></th>
                        <th scope="row"><span>Description</span></th>
                        <th scope="row"><span>Created by</span></th>
                        <th scope="row"><span>Status</span></th>
                        <th scope="row"></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr v-for="catalog in catalogs" :key="catalog.id" data-cy="entityTable">

                        <td class="align-middle"></td>
                        <td class="align-middle">{{ catalog.catalog_key }}</td>
                        <td class="align-middle">{{ catalog.item_name }}</td>
                        <td class="align-middle text-muted">{{ catalog.catalog_description }}</td>
                        <td class="align-middle">{{ catalog.created_by }}</td>

                        <td class="align-middle">
                            <b-badge v-if="catalog.status == true" variant="success">ACTIVE</b-badge>
                            <b-badge v-else variant="danger">INACTIVE</b-badge>
                        </td>
                        <td class="align-middle">
                            <b-button variant="primary" size="sm" @click="editCatalog(catalog)">
                                <font-awesome-icon icon="pencil" size="sm"></font-awesome-icon> Edit
                            </b-button>

                            <b-button variant="danger" size="sm" @click="prepareRemove(catalog)">
                                <font-awesome-icon icon="trash" size="sm"></font-awesome-icon> Detele
                            </b-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>



        <!-- modal de eliminar -->
        <b-modal ref="removeEntity" id="removeEntity">
            <span slot="modal-title"><span id="rodechStoreApp.catalog.delete.question"
                    data-cy="catalogDeleteDialogHeading">Confirmar operación de eliminación</span></span>
            <div class="modal-body">
                <p id="jhi-delete-catalog-heading">¿Está seguro de que desea eliminar el catalogo seleccionado?</p>
                <div>
                    <b-alert show variant="warning">
                        <strong>¡Advertencia¡</strong> El Catalogo solo , se quedará inactivo, pero no será posible
                        visualizarlo.
                    </b-alert>
                </div>
            </div>
            <div slot="modal-footer">
                <button type="button" class="btn btn-secondary" v-on:click="closeDialog()">
                    <font-awesome-icon icon="ban"></font-awesome-icon>
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="jhi-confirm-delete-catalog"
                    data-cy="entityConfirmDeleteButton" v-on:click="removeCatalog()">
                    <font-awesome-icon icon="trash"></font-awesome-icon>
                    Eliminar
                </button>
            </div>
        </b-modal>

        <!-- modal de editar y crear -->
        <b-modal ref="createdEditEntity" id="createdEditEntity">
            <span slot="modal-title"><span id="rodechStoreApp.catalog.delete.question"
                    data-cy="catalogDeleteDialogHeading">{{ createdTitleModal }}</span></span>
            <div class="modal-body">

                <b-form-group label="Código del catálogo">
                    <b-form-input :disabled="catalog.id" v-model="catalog.catalog_key"></b-form-input>
                </b-form-group>
                <b-form-group label="Nombre de catálogo">
                    <b-form-input v-model="catalog.catalog_name"></b-form-input>
                </b-form-group>
                <b-form-group label="Descripción del catálogo">
                    <b-form-textarea id="textarea" placeholder="Enter description for catalog" rows="3"
                        max-rows="6" v-model="catalog.catalog_description"></b-form-textarea>
                </b-form-group>

            </div>
            <div slot="modal-footer">
                <button type="button" class="btn btn-secondary" v-on:click="closeDialog()">
                    <font-awesome-icon icon="ban"></font-awesome-icon>
                    Cancelar
                </button>
                <b-button variant="primary" v-on:click="saveCatalog()">
                    <font-awesome-icon icon="save"></font-awesome-icon>
                    Guardar
                </b-button>
            </div>
        </b-modal>

        <div v-show="catalogs && catalogs.length > 0">
            <div class="row justify-content-center">
                <jhi-item-count :page="page" :total="queryCount" :itemsPerPage="itemsPerPage"></jhi-item-count>
            </div>
            <div class="row justify-content-center">
                <b-pagination size="md" :total-rows="totalItems" v-model="page" :per-page="itemsPerPage"
                    :change="loadPage(page)"></b-pagination>
            </div>
        </div>
    </div>
</template>

<script lang="ts" src="./catalog.component.ts"></script>