<template>
 <div class="container">
    <div class="header bg-orange-8" >
        <div v-if="visible">
            <q-toolbar color="orange-8">
                <q-toolbar-title class="q-pa-none">
                    My Tiffin Provider
                </q-toolbar-title>
                <q-btn flat dense>Next</q-btn>
            </q-toolbar>
            <div class="q-pa-xs">
                <q-search 
                v-model="searchTerm"
                color="orange-8" 
                class="bg-white q-mx-sm q-px-xs"/>
            </div>
        </div>
        <div v-if="!visible">
            <q-toolbar color="orange-8">
                <q-icon name="navigate_before" style="font-size: 30px"  @click.native="visible=!visible"/>
                <q-toolbar-title>
                    My Provider
                </q-toolbar-title>
                <q-btn flat dense>Select</q-btn>
            </q-toolbar>
        </div>
   </div>

    <q-list v-if="visible" highlight separator>
        <q-item v-for="provider in providers" :key="provider.id" @click.native="getProvider(provider)">
          <q-item-side>
            <q-item-tile left>
             <q-icon name="restaurant" style="font-size: 30px"  />
            </q-item-tile>
          </q-item-side>
          <q-item-main>
            <q-item-tile label>{{ provider.name }}</q-item-tile>
            <q-item-tile sublabel>{{ provider.location }}</q-item-tile>
            </q-item-main>
          <q-item-side right>
            <q-radio v-model="providerId" val="opt4" color="green-7" />
            <q-icon name="chevron_right" style="font-size: 25px"  />
          </q-item-side>
        </q-item>
    </q-list>

    <q-card v-if="!visible" :class="[$q.platform.is.desktop ? 'q-ma-lg' : 'q-mx-sm q-mt-xl']" > 
      <q-card-main>
         <q-item>
            <q-item-main >Name</q-item-main>
            <q-item-side >{{ provider.name }}</q-item-side>
          </q-item>
          <q-card-separator />
          <q-item>
            <q-item-main >Mobile</q-item-main>
            <q-item-side >{{ provider.mobile }}</q-item-side>
          </q-item>   
          <q-card-separator />
          <q-item >
            <q-item-main >Address</q-item-main>
            <q-item-side right style="width:70%">{{provider.location}}</q-item-side>
          </q-item>
      </q-card-main>
    </q-card>
</div>
</template>

<script>
import { mapState } from 'vuex'
export default {
    data(){
        return{
            searchTerm:'',
            providerId:'',
            provider:{},
            visible:true
        }
    },
    computed:{
        ...mapState({
            providers:state => state.Tiffin.providers
        })
    },
    mounted(){
        this.getProviders()
    },
    methods:{
        getProviders(){
          this.$store.dispatch('Tiffin/getProviders')
        },
        getProvider(provider){
            this.visible = !this.visible
            this.provider = provider
        }
    }
}
</script>


