<template>
  <div id="q-app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  mounted(){

    var customer = JSON.parse(this.$q.localStorage.get.item('customer'))
    if(customer){
      this.$store.dispatch('Tiffin/getCustomer',{
        customer : customer
      })

    }

  }
}
</script>

<style>
</style>
