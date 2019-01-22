<template>
    <q-page >
      <q-pull-to-refresh :handler="refresher">
        <q-list separator no-border v-if="data" class="q-mt-sm">
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
        <div v-else class="col-12 text-center">
          <p class="text-weight-medium q-mt-xl text-negative">No menu for the day.</p>
        </div>
      </q-pull-to-refresh>
    </q-page>
</template>

<script>
export default {
  computed:{
    data:function(){
      return this.$store.state.Tiffin.provider.menu
    }
  },
  mounted(){
    this.getTodayMenu()
  },
  methods:{
    refresher(done)
    {
      setTimeout(()=>{
        done()
        this.getTodayMenu()
      },1000)
    },
    getTodayMenu(){
      var today = new Date();
      var day = today.getDay(); 
      this.$store.dispatch('Tiffin/setProviderMenu', {
          menuDay: day
        })
    }
  }
}
</script>