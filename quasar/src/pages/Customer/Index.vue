<template>
  <q-page >
        <div class="row full-width justify-center">
            <q-btn-group outline class=" q-pt-sm q-pb-sm">
                <q-btn outline color="orange-8" style="width:150px" label="Menu" @click="$router.push('/customer')" />
                <q-btn outline color="orange-8" style="width:150px" label="Orders" @click="$router.push('/customer/orders')" />
            </q-btn-group>
        </div>
        <router-view /> 
  </q-page>

</template>

<script>
    export default {
        name: 'CustomerPageIndex'
    }
</script>

<style scoped>
    .q-tabs{
    border-radius:0px;
    }
</style>

