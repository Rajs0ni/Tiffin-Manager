<template>
  <q-layout view="lHh Lpr lFf" >
    <q-layout-header reveal color="orange-8">
      <q-toolbar
        color="orange-8"
      >
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
        >
          <q-icon name="menu" />
        </q-btn>
        <q-toolbar-title>
          Tiffin Manager
        </q-toolbar-title>
        </q-toolbar>
        <div class="q-tabs flex no-wrap overflow-hidden q-tabs-position-top q-tabs-normal">
          <div :class="[$q.screen.gt.sm ? 'q-tabs-align-left' :'q-tabs-align-justify' ]">
            <q-tabs class="fit q-tabs-scroller" color="orange-8">
              <q-route-tab slot="title" :to="menuRoute" label="Menu" />
              <q-route-tab slot="title" :to="orderRoute" label="Orders" />
            </q-tabs>
          </div>
        </div>
    </q-layout-header>

    <q-layout-drawer
      v-model="leftDrawerOpen"
      :content-class="$q.theme === 'mat' ? 'bg-grey-2' : null"
    >
      <q-list
        no-border
        link
        inset-delimiter
      >
        <q-list-header>Essential Links</q-list-header>
        <q-item  link to="/customer">
          <q-item-side icon="fas fa-users" />
          <q-item-main label="Customer"  />
        </q-item>
        <q-item  link to="/provider">
            <q-item-side icon="fas fa-user-cog" />
          <q-item-main label="Provider" />
        </q-item>
       
      </q-list>
    </q-layout-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>

export default {
  name: 'MyLayout',
  computed: {
    menuRoute()
    {
      var url = this.$route.path
      url.indexOf('customer')
      return url.indexOf('customer') != -1 ? '/customer' : '/provider'
    },
    orderRoute()
    {
      var url = this.$route.path
      url.indexOf('customer')
      return  url.indexOf('customer') != -1 ? '/customer/orders' : '/provider/orders' 
    }
  },
  data () {
    return {
      leftDrawerOpen: this.$q.platform.is.desktop
    }
  }
}
</script>

