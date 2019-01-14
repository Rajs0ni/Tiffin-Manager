<template>
    <q-collapsible icon="wb_sunny" label="Lunch" opened>
        <q-card inline class="fit">
          <q-card-main>
            <q-item class="text-weight-light">
                  {{ data.menus[0].lunch_desc}}
            </q-item>     
          </q-card-main>
          <q-card-separator />
          <q-card-action>
            <div class="row">
              <q-item>
                  <q-item-main class="q-body-2 q-ml-md">Time to Order :</q-item-main>
                  <q-item-side class="q-body-1">{{ data.lunch_start | parseTime}} - {{ data.lunch_end | parseTime}}</q-item-side>
              </q-item>
            </div>
            <div class="row">
                <div class="col-6 text-left">
                    <q-item class="q-body-2 on-right q-ml-md" >Quantity :<span class="on-right q-caption">{{ Quantity }}</span></q-item>
                </div>
                <div class="col-6 text-right">
                    <q-btn-group outline class="q-pt-sm q-pb-sm on-left">
                      <q-btn outline  size="sm" @click="changeQuantity('incr',Quantity)" color="positive" icon="add" />
                      <q-btn outline  size="sm" @click="changeQuantity('decr',Quantity)" color="positive" icon="remove" />
                    </q-btn-group>
                </div>
            </div>
          </q-card-action>
          <q-card-separator />
          <div class="footer text-center ">
              <div class="q-mt-sm q-mb-sm"> 
                  <q-btn outline color="positive" :disabled="active" label="Order" @click="order(data.price, Quantity)"/>
              </div> 
          </div>
        </q-card>
    </q-collapsible>
</template>

<script>
import * as time from 'src/store/Tiffin/time.js'

export default {
 name:'Lunch',
 data(){
    return{
        Quantity:1,
        active:false
    }
 },
 computed:{
    data:function(){
      return this.$store.state.tiffin.customer.menu
    }
 },
 beforeMount(){
   this.canOrderOrNot()
 },
 methods:{
    canOrderOrNot()
    {
        var date = new Date();
        var current_time = date.getHours();
        var lunch_end = parseInt(this.$q.localStorage.get.item(time.LUNCH_END));
        if( current_time > (lunch_end-1) )
        {
            this.active = !this.active
        }
     },

    changeQuantity(operation, value)
    {
        operation == 'incr' ?
        this.Quantity = value>=4 ? 4 : ++this.Quantity :
        this.Quantity = value<=1 ? 1 : --this.Quantity
    },

    order(time,price)
    {
        this.$store.dispatch('tiffin/saveOrder', {
          quantity:this.Quantity,
          price:price,
          time:time
        })
    }
 }
}
</script>

<style>

</style>
