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

export default {
  data()
  {
    return {
     
    }
  },
  components:{
    lunch,dinner
  },
  computed:{
    
    },
    created()
    {
    this.getTodayMenu()
    },
  methods:{
    getTodayMenu(){
     var today = new Date();
     var day = today.getDay(); 
     this.$store.dispatch('tiffin/setCustomerMenu', {
        menuDay: day
      })
    },
    order(price,quantity,start_from,end_to)
    {
      var date = new Date();
      var hour= (date.getHours()) % 12
      var suffix = hour < 12 ? 'AM' : 'PM'
      var hour = hour+suffix
      if(hour >= end_to || hour<= start_from)
      {
         this.$store.dispatch('tiffin/deliverOrder', {
          quantity:quantity,
          price:price,
          time:time
        })
      }      
      else
      {
      this.$store.dispatch('tiffin/deliverOrder', {
          quantity:quantity,
          price:price,
          time:time
        })
    }
  }
}
}
</script>
