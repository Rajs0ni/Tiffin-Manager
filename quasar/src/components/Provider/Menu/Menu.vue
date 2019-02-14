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
import Display from 'components/Provider/Menu/Display.vue'
import { mapState } from 'vuex';
export default {
  components:{
    Display
  },
  computed:{
   ...mapState({
     menus: state => state.Tiffin.provider.menu,
   }),
  dayName:function()
    {
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var today = new Date(); 
        return days[today.getDay()];
    }
  },
  mounted(){
    this.getTodayMenu()
  },
  methods:{
    refresher(done)
    {
      setTimeout(()=>{
        done()
        this.getTodayMenu()
      },1000)
    },
    getTodayMenu(){
      var today = new Date();
      var day = today.getDay(); 
      this.$store.dispatch('Tiffin/setProviderMenu', {
          tiffin_id:2,
          day: day
        })
    }
  }
}
</script>