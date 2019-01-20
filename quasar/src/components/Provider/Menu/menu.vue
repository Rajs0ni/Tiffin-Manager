<template>
<q-page >
<q-card inline class="full-width">
    <q-card-title>
    <q-item>
    <q-item-main>
      <q-item-tile label>Provider</q-item-tile>
      <q-item-tile sublabel>Subhead</q-item-tile>
    </q-item-main>
  </q-item>
    </q-card-title>
    
    <q-card-main>
         <q-item>
        Moong Sebut, Green Veg, Plain Rice, Tava Roti, Green Salad
         </q-item>
    </q-card-main>
     <q-card-separator />
    <!-- <q-card-action class="flex flex-center">
        <q-btn round dense color="positive" >+</q-btn>
        <h6 flat color="primary" size="md" class="q-pl-md">Quantity</h6>
        <q-btn round dense color="grey-5" class="q-ml-md">-</q-btn>
    </q-card-action> -->
</q-card>
</q-page>
</template>

<script>
export default {
  computed:{
    menu:function(){
      return this.$store.state.tiffin.provider.menu
    }
  },
  mounted(){
    this.getTodayMenu()
  },
  methods:{
    getTodayMenu(){
      var today = new Date();
      var day = today.getDay(); 
      this.$store.dispatch('tiffin/setProviderMenu', {
          menuDay: day
        })
    }
  }
}
</script>