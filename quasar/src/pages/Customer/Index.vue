
<template>
  <q-page>
    <flash></flash>
    <router-view /> 
  </q-page>
</template>

<script>
import flash from 'components/flash_message.vue'
export default {
    name: 'CustomerPageIndex',
    components:{
    flash
  }
}
</script>


