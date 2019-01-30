
<template>
  <q-page>
    <flash></flash>
    <router-view /> 
  </q-page>
</template>

<script>
import flash from 'components/FlashMessage.vue'
export default {
    name: 'CustomerIndex',
    components:{
    flash
  }
}
</script>


