<template>
  <q-page >
    <q-pull-to-refresh :handler="refresher">
      <q-list separator no-border class="q-mt-sm">
        <Display v-for="(value,key,index) in menus" :menu="value" :key="index" :title="key"></Display>
      </q-list>
    </q-pull-to-refresh>
  </q-page>
</template>

<script>
import Display from 'components/Customer/Menu/Display.vue'
import { mapState } from 'vuex';

export default {
  components:{
    Display
  },
  created(){
    this.getTodayMenu()
  },
 computed:{
   ...mapState({
     menus: state => state.Tiffin.customer.menu,
     customer:state => state.Tiffin.customer.detail
   }),
 },
  methods:{
    refresher (done) {
      setTimeout(() => {
        this.getTodayMenu()
        done()
      }, 1000)
    },
    getTodayMenu()
    {
      var today = new Date();
      var day = today.getDay();  
      this.$store.dispatch('Tiffin/setCustomerMenu', {
          customer:this.customer,
          menuDay: day
        })
    },
}
}
</script>
