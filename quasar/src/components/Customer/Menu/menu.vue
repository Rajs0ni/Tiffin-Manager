<template>
<q-page >
    <q-list separator no-border>
      <lunch></lunch>
      <dinner></dinner>
  </q-list>
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
    getTodayMenu()
    {
      var today = new Date();
      var day = today.getDay(); 
      this.$store.dispatch('tiffin/setCustomerMenu', {
          menuDay: day
        })
        .then(()=>{
          let lunch_start = this.$store.state.tiffin.customer.menu.lunch_start
          let lunch_end = this.$store.state.tiffin.customer.menu.lunch_end
          let dinner_start = this.$store.state.tiffin.customer.menu.dinner_start
          let dinner_end = this.$store.state.tiffin.customer.menu.dinner_end
          this.$q.localStorage.set(time.LUNCH_START, lunch_start)
          this.$q.localStorage.set(time.LUNCH_END, lunch_end)
          this.$q.localStorage.set(time.DINNER_START, dinner_start)
          this.$q.localStorage.set(time.DINNER_END, dinner_end)
        })
    },
  //   order(price,quantity,start_from,end_to)
  //   {
  //     var date = new Date();
  //     var hour= (date.getHours()) % 12
  //     var suffix = hour < 12 ? 'AM' : 'PM'
  //     var hour = hour+suffix
  //     if(hour >= end_to || hour<= start_from)
  //     {
  //        this.$store.dispatch('tiffin/deliverOrder', {
  //         quantity:quantity,
  //         price:price,
  //         time:time
  //       })
  //     }      
  //     else
  //     {
  //     this.$store.dispatch('tiffin/deliverOrder', {
  //         quantity:quantity,
  //         price:price,
  //         time:time
  //       })
  //   }
  // }
}
}
</script>
