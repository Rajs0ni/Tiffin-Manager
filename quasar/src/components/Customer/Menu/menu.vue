<template>
<q-page >
  <p>{{flashMessage}}</p>
    <q-list separator>
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
              {{ menu.lunch_start + '-' + menu.lunch_end }} <br/>
              {{ menu.dinner_start + '-' + menu.dinner_end}}
            </div>
            <q-card-separator />
            <div class="row">
                <div class="col-6 text-left">
                    <q-item class="q-body-2 on-right" >Quantity :<span class="on-right q-caption">{{ Lquantity }}</span></q-item>
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
              <div class="q-mt-sm q-mb-sm"> <q-btn outline color="positive" label="Order" @click="order(menu.price,Lquantity,menu.lunch_start,menu.lunch_end)"/></div> 
          </div>
        </q-card>
      </q-collapsible>

      <q-collapsible icon="brightness_3" label="Dinner">
        <q-card inline class="fit">
          <q-card-main>
             <q-item class="text-weight-light">
                {{ menu.menus[0].dinner_desc}}
             </q-item>
          </q-card-main>
          <q-card-separator />
          <q-card-action>
            <div class="row">
                <div class="col-6 text-left">
                   <q-item class="q-body-2 on-right" >Quantity :<span class="on-right q-caption">{{ Dquantity }}</span></q-item>
                </div>
                <div class="col-6 text-right">
                    <q-btn-group outline class="q-pt-sm q-pb-sm on-left">
                      <q-btn outline  size="sm" @click=Dquantity++ color="positive" icon="add" />
                      <q-btn outline  size="sm" @click=Dquantity-- color="positive" icon="remove" />
                    </q-btn-group>
                </div>
            </div>
          </q-card-action>
          <q-card-separator />
          <div class="footer text-center ">
              <div class="q-my-sm"> <q-btn outline color="positive" @click="order('dinner', menu.price, Dquantity)" label="Order"/></div> 
          </div>
      </q-card>
    </q-collapsible>
  </q-list>
</q-page>
</template>

<script>
export default {
  data(){
    return {
      Lquantity:1,
      Dquantity:1,
    }
    
  },
  computed:{
    menu:function(){
      return this.$store.state.tiffin.customer.menu
    },
    flashMessage:function(){
       return this.$store.state.tiffin.flash_message
    }
  },
  mounted(){
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
        alert('order cannot be placed')
         this.$store.dispatch('tiffin/deliverOrder', {
          quantity:quantity,
          price:price,
          time:time
        })
      }      
      else
      {
        alert('yes you can order')
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
