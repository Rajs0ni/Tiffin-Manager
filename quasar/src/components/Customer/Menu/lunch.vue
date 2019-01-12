<template>
    <q-collapsible icon="wb_sunny" label="Lunch" opened>
        <q-card inline class="fit">
          <q-card-main>
            <q-item class="text-weight-light">
                  {{ menu.menus[0].lunch_desc}}
            </q-item>     
          </q-card-main>
          <q-card-separator />
          <q-card-action>
            <div class="row">
              <q-item>
                  <q-item-main class="q-body-2 q-ml-md">Time to Order :</q-item-main>
                  <q-item-side class="q-body-1">{{ menu.lunch_start | parseTime}} - {{ menu.lunch_end | parseTime}}</q-item-side>
              </q-item>
            </div>
            <div class="row">
                <div class="col-6 text-left">
                    <q-item class="q-body-2 on-right q-ml-md" >Quantity :<span class="on-right q-caption">{{ Lquantity }}</span></q-item>
                </div>
                <div class="col-6 text-right">
                    <q-btn-group outline class="q-pt-sm q-pb-sm on-left">
                      <q-btn outline  size="sm" @click=Lquantity++ color="positive" icon="add" />
                      <q-btn outline  size="sm" @click=Lquantity-- color="positive" icon="remove" />
                    </q-btn-group>
                </div>
            </div>
          </q-card-action>
          <q-card-separator />
          <div class="footer text-center ">
              <div class="q-mt-sm q-mb-sm"> <q-btn outline color="positive" :disabled="active" label="Order" @click="order(menu.price,Lquantity,menu.lunch_start,menu.lunch_end)"/></div> 
          </div>
        </q-card>
    </q-collapsible>
</template>

<script>
export default {
 name:'Lunch',
 data(){
     return{
         Lquantity:1,
         active:false
     }
 },
 computed:{
      menu:function(){
      return this.$store.state.tiffin.customer.menu
    }
 },
 mounted()
 {
    var date = new Date();
    var current_time = date.getHours();
    var lunch_start = parseInt(this.$store.state.tiffin.customer.menu.lunch_start)
    var lunch_end = parseInt(this.$store.state.tiffin.customer.menu.lunch_end)
    if( current_time > lunch_end )
    {
      this.active = !this.active
    }
 }
}
</script>

<style>

</style>
