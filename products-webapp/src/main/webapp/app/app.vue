<template>
  <div id="app">
    <ribbon></ribbon>
    <div id="app-header">
      <jhi-navbar></jhi-navbar>
    </div>
    <!-- <div class="container-fluid">
      <div class="card jh-card">
        <router-view></router-view>
      </div>
      <b-modal id="login-page" hide-footer lazy>
        <span data-cy="loginTitle" slot="modal-title" id="login-title" v-text="$t('login.title')">Sign in</span>
        <login-form></login-form>
      </b-modal>

      <jhi-footer></jhi-footer>
    </div> -->
    <div class="container-fluid">
      <div class="row" v-if="authenticated">
        <div class="bd-sidebar scroll col-2" style="background: #353d47; color: #ffffff">
          <navbar-vertical></navbar-vertical>
        </div>
        <div class="bd-content col-10" style="box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.16)">
        
          <div class="card jh-card">
            <keep-alive :include="['Products']">
              <router-view></router-view>
            </keep-alive>
          </div>
        </div>
      </div>
      <div v-if="!authenticated">
        <div class="card jh-card">
          <router-view></router-view>
        </div>
      </div>
      <b-modal id="login-page" hide-footer lazy>
        <span data-cy="loginTitle" slot="modal-title" id="login-title">Iniciar sesión</span>
        <login-form></login-form>
      </b-modal>

      <jhi-footer></jhi-footer>
    </div>
  </div>
</template>

<script lang="ts" src="./app.component.ts"></script>
