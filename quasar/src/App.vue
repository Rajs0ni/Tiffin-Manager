<template>
  <div id="q-app">
    <router-view />
  </div>
</template>

<script>
import helper from './store/helper'
import * as types from './store/types.js';
export default {
  name: 'App',
  mounted(){
    // alert(helper.isLoggedIn())
    // if(this.$q.localStorage.has('customer'))
    // {
    //    const customer = this.$q.localStorage.get.item('customer')
    //    this.$store.dispatch('Tiffin/getCustomer', {
    //      customer:customer
    //     })
    // }

  }
}
</script>

<style>
</style>
