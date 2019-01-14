<template>
<q-page >
  <q-list separator no-border>
     <q-collapsible icon="wb_sunny" label="Lunch" opened>
        <q-card inline class="fit">
          <q-card-main>
            <q-item class="text-weight-light">
                  {{ data.menus[0].lunch_desc}}
            </q-item>     
          </q-card-main>
        </q-card>
     </q-collapsible>
     <q-card-separator />
     <q-collapsible icon="brightness_3" label="Dinner" opened>
        <q-card inline class="fit">
          <q-card-main>
            <q-item class="text-weight-light">
                  {{ data.menus[0].dinner_desc}}
            </q-item>     
          </q-card-main>
        </q-card>
     </q-collapsible>
  </q-list>
</q-page>
</template>

<script>
export default {
  computed:{
    data:function(){
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