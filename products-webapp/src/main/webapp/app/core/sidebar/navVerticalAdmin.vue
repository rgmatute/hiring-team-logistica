<template>
  <div class="mt-4">
    <b-nav pills vertical style="font-family: montserrat-regular">
      <b-nav-item to="/">
        <span>
          <font-awesome-icon icon="home" class="icon" /> &nbsp;
          <span>Home</span>
        </span>
      </b-nav-item>
      <b-nav-item to="/admin/products">
        <span>
          <font-awesome-icon icon="cart-shopping" class="icon" /> &nbsp;
          <span>Products</span>
        </span>
      </b-nav-item>
      <b-nav-item to="/admin/catalogs">
        <span>
          <font-awesome-icon icon="book" class="icon" /> &nbsp;
          <span>Catalogs</span>
        </span>
      </b-nav-item>
      <!-- <b-nav-item to="/history">
        <span>
          <font-awesome-icon icon="file-text" class="icon" /> &nbsp;
          <span>History</span>
        </span>
      </b-nav-item> -->
      <hr style="width: -webkit-fill-available; background-color: #ece0e0" />
      <b-nav-item v-on:click="logout()">
        <span>
          <font-awesome-icon icon="sign-in-alt" class="icon" /> &nbsp;
          <span>Sign out</span>
        </span>
      </b-nav-item>
    </b-nav>
  </div>
</template>
<script lang="ts" src="./navVerticalAdmin.component.ts"></script>
<style scoped>
a {
  color: #ffffff;
  font-size: 16px;
  font-weight: normal;
}
.nav {
  margin-left: -15px;
}
@media screen and (max-width: 1000px) {
  span span {
    display: none;
  }
}
.icon {
  font-size: 13px;
}
a:hover {
  color: #565656;
  font-weight: normal;
  /* make sure browsers use the pointer cursor for anchors, even with no href */
  cursor: pointer;
}
li {
  list-style-type: none;
}
</style>
