<template>
    <q-card :class="[$q.platform.is.desktop ? 'q-ma-lg' : 'q-mx-sm q-mt-xl']" >
      <q-card-title class="text-orange-10">
          Order Id : {{ order.record.id }}
      </q-card-title>    
      <q-card-separator />   
      <q-card-main>
         <q-item>
            <q-item-main class="on-right">Lunch/Dinner</q-item-main>
            <q-item-side class="on-left">{{ order.is_lunch?'Lunch':'Dinner' }}</q-item-side>
          </q-item>
          <q-card-separator />
          <q-item>
            <q-item-main class="on-right">Tiffin Plan</q-item-main>
            <q-item-side class="on-left">{{ order.tiffin_plan }}</q-item-side>
          </q-item>   
          <q-card-separator />
          <q-item>
            <q-item-main class="on-right">Quantity</q-item-main>
            <q-item-side class="on-left">{{ order.record.no_of_tiffin }}</q-item-side>
          </q-item>
           <q-card-separator />
           <q-item>
            <q-item-main class="on-right">Price</q-item-main>
            <q-item-side class="on-left">Rs. {{ order.record.price }}</q-item-side>
          </q-item>
          <q-card-separator />
           <q-item>
            <q-item-main class="on-right">Date</q-item-main>
            <q-item-side class="on-left">{{ order.record.created_at | parseDate }}</q-item-side>
          </q-item>
          <q-card-separator />
           <q-item>
            <q-item-main class="on-right">Total Amount</q-item-main>
            <q-item-side class="on-left">Rs. {{ order.record.total_amount }}</q-item-side>
          </q-item>
          <q-card-separator />
           <q-item>
            <q-item-main class="on-right">Status</q-item-main>
            <q-item-side :class="[ order.record.status ? 'text-positive' : 'text-negative' , 'on-left']">
              {{ order.record.status | status}}
            </q-item-side>
          </q-item>
      </q-card-main>
    </q-card>
 </template>

<script>
import {mapState} from 'vuex'
export default {
  computed:{
     ...mapState({
            order:state => state.Tiffin.customer.order,
            customer:state => state.Tiffin.user
        })
  },
  mounted(){
     this.getOrder();
  },
  methods:{
    getOrder(){
      if(this.$route.params.id)
      {
        this.$store.dispatch('Tiffin/setCustomerOrder',{
          user_id:this.customer.id,
          order_id:this.$route.params.id
        })  
      }
    }
  }
}
</script>