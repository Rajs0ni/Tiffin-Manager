<template>
  <q-page >
    <q-pull-to-refresh :handler="refresher">
      <q-list separator no-border class="q-mt-sm">
        <lunch></lunch>
        <dinner></dinner>
      </q-list>
    </q-pull-to-refresh>
  </q-page>
</template>

<script>
import lunch from 'components/Customer/Menu/lunch.vue'
import dinner from 'components/Customer/Menu/dinner.vue'
import * as time from 'src/store/Tiffin/time.js'

export default {
  components:{
    lunch,dinner
  },
  created(){
    this.getTodayMenu()
  },
  methods:{
    refresher (done) {
      setTimeout(() => {
        done()
         this.getTodayMenu()
      }, 1000)
    },
    getTodayMenu()
    {
      var today = new Date();
      var day = today.getDay(); 
      this.$store.dispatch('Tiffin/setCustomerMenu', {
          menuDay: day
        })
        .then(()=>{
          this.storeTimeLocally();
        })
    },
    storeTimeLocally(){
        let lunch_start = this.$store.state.Tiffin.customer.menu.lunch_start
        let lunch_end = this.$store.state.Tiffin.customer.menu.lunch_end
        let dinner_start = this.$store.state.Tiffin.customer.menu.dinner_start
        let dinner_end = this.$store.state.Tiffin.customer.menu.dinner_end
        if(lunch_start && lunch_end && dinner_start && dinner_end)
        {
          this.$q.localStorage.set(time.LUNCH_START, lunch_start)
          this.$q.localStorage.set(time.LUNCH_END, lunch_end)
          this.$q.localStorage.set(time.DINNER_START, dinner_start)
          this.$q.localStorage.set(time.DINNER_END, dinner_end)
        }
    }
}
}
</script>
