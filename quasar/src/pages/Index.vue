<template>
  <q-page class="">
    <!-- <img alt="Quasar logo" src="~assets/quasar-logo-full.svg"> -->
  
<div class="row full-width ">
   <q-tabs class="full-width" color="orange-8">
        <q-route-tab
          to="/index/demo1"
          name="tab-1"
          exact
          slot="title"
          label="Menu"
        />
        <q-route-tab
          to="/index/demo2"
          exact
          slot="title"
          label="Orders"
        />
  </q-tabs>
</div>
<router-view /> 
  </q-page>

</template>

<style>
</style>

<script>
export default {
  name: 'PageIndex'
}
</script>
<style scoped>

.q-tabs{
border-radius:0px;
}
</style>
