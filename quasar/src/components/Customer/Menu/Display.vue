<template>
<div>   
     <q-collapsible :icon="title=='Lunch' ? 'wb_sunny': 'brightness_3'"  :label="title" opened >
        <q-card inline class="fit" v-if="menu">
          <q-card-main>
            <q-item class="text-weight-light">
                  {{ menu.desc }}
            </q-item>     
          </q-card-main>
          <q-card-separator />
          <q-card-actions>
           <div class="row fit">
              <q-item class="q-ml-sm">
                  <q-item-main class="q-body-2 ">Time to Order :</q-item-main>
                  <q-item-side class="q-body-1">{{ menu.start_time | parseTime }} - {{ menu.end_time | parseTime }}</q-item-side>
              </q-item>
           </div>
            <div class="row fit">
                <div class="col-6">
                    <q-item class="q-body-2 q-ml-sm">Quantity :<span class="on-right q-caption">{{ Quantity }}</span></q-item>
                </div>
                <div class="col-6 text-right">
                    <q-btn-group outline class="q-pt-sm on-left">
                        <q-btn outline  size="sm"  @click="changeQuantity('incr', Quantity)" color="positive" icon="add" style="margin-right:-1px" />
                        <q-btn outline  size="sm"  @click="changeQuantity('decr', Quantity)" color="positive" icon="remove" />
                    </q-btn-group>
                </div>
            </div>
          </q-card-actions>
          <q-card-separator />
          <div class="text-center">
              <div class="q-mt-sm q-mb-sm"> 
                  <q-btn outline color="positive" :loading="loading" :disabled="active"  @click="order(title,menu)">
                       Order<span slot="loading"><q-spinner-hourglass class="text-center" />Loading...</span>
                  </q-btn>
              </div> 
          </div>
        </q-card>
        <div v-else class="col-12 text-center">
            <p class="text-weight-medium q-mt-md text-negative">No menu for the day.</p>
        </div>
    </q-collapsible>
</div>
</template>

<script>
import { mapState } from 'vuex'
export default {
    name:'Lunch',
    props:['menu','title'],
    data(){
        return{
            Quantity:1,
            active:false,
            loading:false
        }
    },
    computed:{
          ...mapState({
         customer: state => state.Tiffin.customer.detail 
        }),
    },
    methods:{
        canOrderOrNot(menu)
            {
                var date = new Date();
                var current_time = date.getHours();
                return current_time < parseInt(menu.end_time)
            },

        changeQuantity(operation, value)
            {
                operation == 'incr' ?
                this.Quantity = value>=4 ? 4 : ++this.Quantity :
                this.Quantity = value<=1 ? 1 : --this.Quantity
            },

        order(title,menu){
          if(this.canOrderOrNot(menu))
          {
            var date = new Date();
            var current_time = date.getHours();
            this.$store.dispatch('Tiffin/saveOrder', {
                    customer:this.customer,
                    quantity:this.Quantity,
                    data:menu,
                    time:current_time 
                })
          }
          else
          {
            this.$store.dispatch('Tiffin/setFlash',{
                    icon:"error",
                    type:"negative",
                    message:title + " time is over"
                })
          }
        }
    }
}
</script>

<style>

</style>
