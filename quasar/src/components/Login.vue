<template>
    <div>
        <flash></flash>
        <div class="row window-height window-width text-center">
            <div class="col-12">
                <div class="row q-mt-xl">
                    <div class="col-12 ">
                        <img class="img-fluid img-responsive" style="width:32vh;height:25vh" src="~assets/logo.png">
                    </div>
                </div>
                <br><br><br><br>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-3">
                        <span>Mobile :</span>
                    </div>
                    <div class="col-7">
                        <q-input 
                           prefix="+91-" 
                           v-model="customer.mobile"
                           class="q-pa-none" 
                           color="orange-8"
                           placeholder="Your Mobile Number..." 
                           type="number"  />
                    </div>
                    <div class="col-1"></div>
                </div>
                <br><br>
                <div class="row text-white">
                    <div class="col-12">
                        <q-btn @click.native="getOTP()" class="bg-orange-8 text-white text-weight-bold">Get OTP</q-btn>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>

<script>
import { mapState } from 'vuex'
import flash from 'components/FlashMessage.vue'
export default {
    components:{
        flash
    },
    computed:{
         ...mapState({
            customer: state => state.Tiffin.customer.detail
        }),
    },
    methods:{
        getOTP(){
            this.$store.dispatch('Tiffin/getOTP',{
                customer : this.customer
            })
            .then((resposne) =>{
                if(resposne.status != 200)
                    this.$store.dispatch('Tiffin/filterResponse',resposne)
                else
                {
                    this.$q.localStorage.set('customer', JSON.stringify(this.customer))
                    this.$router.push('/verify')
                }
            })
            
        }
    }

}
</script>

<style>

</style>
