<template>
    <q-collapsible icon="brightness_3" label="Dinner" opened>
        <q-card inline class="fit">
          <q-card-main>
            <q-item class="text-weight-light">
                  {{ data.menus[0].dinner_desc}}
            </q-item>     
          </q-card-main>
          <q-card-separator />
          <q-card-actions>
           <div class="row fit">
              <q-item class="q-ml-sm">
                  <q-item-main class="q-body-2 ">Time to Order :</q-item-main>
                  <q-item-side class="q-body-1">{{ data.dinner_start | parseTime}} - {{ data.dinner_end | parseTime}}</q-item-side>
              </q-item>
         </div>
         <div class="row fit">
                <div class="col-6">
                    <q-item class="q-body-2 q-ml-sm">Quantity :<span class="on-right q-caption">{{ Quantity }}</span></q-item>
                </div>
                <div class="col-6 text-right">
                    <q-btn-group outline class="q-pt-sm on-left">
                      <q-btn outline  size="sm"  @click="changeQuantity('incr',Quantity)" color="positive" icon="add" style="margin-right:-1px" />
                      <q-btn outline  size="sm"  @click="changeQuantity('decr',Quantity)" color="positive" icon="remove" />
                    </q-btn-group>
                </div>
          </div>
          </q-card-actions>
          <q-card-separator />
          <div class="text-center">
              <div class="q-mt-sm q-mb-sm"> 
                  <q-btn outline color="positive" :disabled="active" label="Order" @click="order(data)"/>
              </div> 
          </div>
        </q-card>
    </q-collapsible>
</template>

<script>
import * as time from 'src/store/Tiffin/time.js'

export default {
 name:'Dinner',
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
        var dinner_end = parseInt(this.$q.localStorage.get.item(time.DINNER_END))
        if( current_time > (dinner_end-1) )
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

    order(data)
    {
        var date = new Date();
        var current_time = date.getHours();
        this.$store.dispatch('tiffin/saveOrder', {
          quantity:this.Quantity,
          data:data,
          time:current_time
        })
    }
 }
 
}
</script>

<style>

</style>
