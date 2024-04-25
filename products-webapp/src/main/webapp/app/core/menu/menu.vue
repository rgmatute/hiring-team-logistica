<template>
    <div>
        <NavVerticalAdmin v-if="isAuthority(['ROLE_ADMIN'])"></NavVerticalAdmin>
        <NavVerticalCustomer v-if="isAuthority(['ROLE_USER']) && !isAuthority(['ROLE_ADMIN'])"></NavVerticalCustomer>
    </div>
</template>
<script lang="ts" src="./menu.component.ts">
</script>
