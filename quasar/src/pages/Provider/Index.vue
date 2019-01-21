
<template>
  <q-page clas="fit">
    <flash></flash>
    <keep-alive>
        <router-view /> 
    </keep-alive>
</q-page>

</template>

<script>
import flash from 'components/flash_message.vue'
export default {
    name: 'ProviderPageIndex',
    components:{
        flash
    }
}
</script>

