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
    helper.setCustomerFromStorage()
  }
}
</script>

<style>
</style>
