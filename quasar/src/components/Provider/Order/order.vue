<template>
    <q-card class="q-mx-sm q-mt-xl">
      <q-card-title class="text-orange-10">
          Order Id : {{ order.record.id }}
      </q-card-title>    
      <q-card-separator />   
      <q-card-main>
          <q-item>
            <q-item-main class="on-right">Customer Name</q-item-main>
            <q-item-side class="on-left">{{ order.customer_name }}</q-item-side>
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
      <q-card-separator />
      <q-card-actions>
          <div class="fit text-center">
             <q-btn outline color="positive" label="Deliver" @click="deliverOrder(order.record.id)"/>
          </div>
      </q-card-actions>
    </q-card>
 </template>

<script>
export default {
  computed:{
    order(){
        return this.$store.state.tiffin.provider.order
    }
  },
  mounted(){
     this.getOrder();
  },
  filters:{
      status(value){
          return value?'Delivered':'Pending';
      }
    },
  methods:{
    getOrder(){
      if(this.$route.params.id)
      {
          this.$store.dispatch('tiffin/setProviderOrder',{
            user_id:1,
		    order_id:this.$route.params.id
          })  
      }
    },
    deliverOrder(id)
    {
        this.$store.dispatch('tiffin/processOrder',{
        order_id:id
        }).then(()=>{
          this.getOrder()
        })
    }
  }
}
</script>