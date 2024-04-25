<template>
    <div>
        <b-nav pills vertical style="font-family: montserrat-regular;" >
           <b-nav-item to="/">
                <span>
                    <font-awesome-icon icon="home"  class="icon"/> &nbsp;
                    <span>Inicio</span>
                </span>
            </b-nav-item>
            <b-nav-item to="/">
                <span>
                    <font-awesome-icon icon="shopping-bag" class="icon"/> &nbsp;
                    <span>Compras Realizadas</span>
                </span>
            </b-nav-item>
            <hr style="width: -webkit-fill-available; background-color: #ece0e0" />
            <b-nav-item v-on:click="logout()">
                <span>
                    <font-awesome-icon icon="sign-in-alt" class="icon"/> &nbsp;
                    <span>Sign out</span>
                </span>
            </b-nav-item>
        </b-nav>
    </div>
</template>
<script lang="ts" src="./navVerticalCustomer.component.ts">
</script>
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
        span span{
            display:none;
        }
    }
    .icon{
        font-size:13px;
    }
    a:hover {
        color: #565656;
        font-weight: normal;
        /* make sure browsers use the pointer cursor for anchors, even with no href */
        cursor: pointer;
    }
    li{
        list-style-type: none;
    }
</style>
