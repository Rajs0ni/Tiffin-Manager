<template>
  <q-page >
    <q-pull-to-refresh :handler="refresher">
      <div class="row">
        <div class="col-12 text-left q-py-md">
          <div class="on-right">
           <span class="text-weight-bold text-orange-8">Day</span> : <span>{{ dayName }}</span>
         </div>
        </div>
      </div>
        <q-card-separator />
      <q-list no-border>
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
     customer: state => state.Tiffin.user
   }),
   dayName:function()
   {
      var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
      var today = new Date(); 
      return days[today.getDay()];
   }
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
          tiffin_id:this.customer.tiffin_plan,
          day: day
        })
    },
}
}
</script>
