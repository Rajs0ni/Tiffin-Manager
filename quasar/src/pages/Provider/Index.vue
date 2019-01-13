
<template>
  <q-page >
        <div class="row full-width ">
            <q-tabs class="full-width" color="orange-8">
                    <q-route-tab
                    to="/provider"
                    name="tab-1"
                    exact
                    slot="title"
                    label="Menu"
                    />
                    <q-route-tab
                    to="/provider/orders"
                    exact
                    slot="title"
                    label="Orders"
                    />
            </q-tabs>
        </div>
        <router-view /> 
  </q-page>

</template>

<script>
    export default {
        name: 'ProviderPageIndex'
    }
</script>

<style scoped>
    .q-tabs{
    border-radius:0px;
    }
</style>
