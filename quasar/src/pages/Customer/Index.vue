<template>
  <q-page >
        <div class="row full-width justify-center">
            <q-btn-group outline class=" q-pt-sm q-pb-sm">
                <q-btn outline color="orange-8" style="width:150px" label="Menu" @click="$router.push('/customer')" />
                <q-btn outline color="orange-8" style="width:150px" label="Orders" @click="$router.push('/customer/orders')" />
            </q-btn-group>
        </div>
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


