<template>
<q-page >
    <q-card inline class="full-width">
        <q-card-title>
          <q-item>
              <q-item-main>
                <q-item-tile label>Customer</q-item-tile>
                <q-item-tile sublabel>Subhead</q-item-tile>
              </q-item-main>
          </q-item>
        </q-card-title>
        <q-card-main>
            <q-item class="text-weight-regular">
                 {{ menu.menus[0].lunch_desc}}
            </q-item>
        </q-card-main>
        <q-card-separator />
        <q-card-action>
          <div class="row">
              <div class="col-6 text-left">
                <q-item class="q-body-2 on-right" >Quantity :<span class="on-right q-caption">1</span></q-item>
              </div>
              <div class="col-6 text-right">
                  <q-btn-group outline class="q-pt-sm q-pb-sm on-left">
                          <q-btn outline  size="sm" color="positive" icon="fas fa-plus" />
                          <q-btn outline  size="sm" color="positive" icon="fas fa-minus" />
                  </q-btn-group>
              </div>
          </div>
        </q-card-action>
        <q-card-separator />
        <div class="footer text-center ">
            <div class="q-mt-sm q-mb-sm"> <q-btn outline color="positive" label="Order"/></div> 
        </div>
    </q-card>
</q-page>
</template>

<script>
export default {
  computed:{
    menu:function(){
      return this.$store.state.tiffin.customer.menu
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
    }
  }
}
</script>
