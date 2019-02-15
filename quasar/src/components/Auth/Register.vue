<template>
     <div>
        <flash></flash>
        <div class="row window-height window-width text-center">
            <div class="col-12">
                <div class="row q-mt-xl">
                    <div class="col-12 ">
                        <img class="img-fluid" style="width:32vh;height:25vh" src="~assets/logo.png">
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">
                        <p class="text-orange-8 q-title">
                            Register new account
                        </p><br>
                        <q-input 
                           v-model="customer.name"
                           color="orange-8"
                           align="center"
                           placeholder="Your Name" 
                           type="text"  />
                           <br>
                        <q-input 
                           v-model="customer.location"
                           color="orange-8"
                           align="center"
                           placeholder="Your Location" 
                           type="text"  />
                    </div>
                    <div class="col-1"></div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-12">
                        <q-btn 
                            @click="register()" 
                            class="bg-orange-8 text-white text-weight-bold">
                            Proceed
                        </q-btn>
                    </div>
                </div>
            </div>
         </div>
    </div>
</template>

<script>
import {mapState} from 'vuex';
import flash from 'components/FlashMessage.vue'

export default {
 components:{
        flash
    },
 computed:{
            ...mapState({
            customer: state => state.Tiffin.user
        }),
    },
 methods:{
    register(){
        const self = this
        this.$store.dispatch('Tiffin/register',{
            customer:this.customer,
            callback:function(response){
                self.$q.localStorage.set('customer_secret', response.data.remember_token)
                self.$q.localStorage.set('customer',response.data)
                self.$router.push({path:'/myprovider'})
            }
        })
    }
 }
}
</script>

<style>

</style>
