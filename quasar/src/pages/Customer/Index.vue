
<template>
  <q-page>
    <flash></flash>
    <keep-alive>
        <router-view /> 
    </keep-alive>
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


