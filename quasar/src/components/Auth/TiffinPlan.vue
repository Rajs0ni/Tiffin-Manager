<template>
    <div class="container bg-grey-4 fit">
        <div class="header bg-orange-8" >
            <div>
                <q-toolbar color="orange-8">
                    <q-toolbar-title class="q-pa-none">
                        My Tiffin Plan
                    </q-toolbar-title>
                    <q-btn flat dense @click="setTiffinPlan()">Next</q-btn>
                </q-toolbar>
            </div>
        </div>
        <q-card class="no-shadow bg-white q-ma-xs">
  <q-card-main>
   <q-item class="q-pa-none">
          <q-item-side>
            <q-item-tile left>
             <q-icon name="restaurant" style="font-size: 20px"  />
            </q-item-tile>
          </q-item-side>
          <q-item-main>
            <q-item-tile label>Long Bite</q-item-tile>
            <q-item-tile sublabel>3 roti, kjfdk,. fdj,jfh3 roti, kjfdk,. fdj,jfh</q-item-tile>
            </q-item-main>
          <q-item-side right>
            <q-radio v-model="opt" val="opt4" color="green-7" />
          </q-item-side>
        </q-item>
  </q-card-main>
</q-card>
    </div>
</template>

<script>
export default {
    data(){
        return{
            opt:''
        }
    },
    methods:{
        setTiffinPlan(){
            
        }
    }
}
</script>

<style>

</style>
