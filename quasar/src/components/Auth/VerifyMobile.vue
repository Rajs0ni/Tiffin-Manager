<template>
    <div>
        <flash></flash>
        <div class="row window-height window-width text-center">
            <!-- Get OTP -->
            <div class="col-12" v-show="!otpGot">
                <div class="row q-mt-xl">
                    <div class="col-12 ">
                        <img class="img-fluid" style="width:32vh;height:25vh" src="~assets/logo.png">
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
                           placeholder="Your Mobile Number" 
                           type="number"  />
                    </div>
                    <div class="col-1"></div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-12">
                        <q-btn 
                            @click.native="getOTP()" 
                            class="bg-orange-8 text-white text-weight-bold">
                            Get OTP
                        </q-btn>
                    </div>
                </div>
            </div>

            <!-- Verify OTP -->
            <div class="col-12" v-if="otpGot">
                <div class="row q-mt-xl">
                    <div class="col-12">
                        <p class="q-title text-weight-bold">Please enter the OTP to verify your account</p>
                        <p class="q-subheading">A OTP has been sent to <b>{{ customer.mobile }}</b></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 q-mt-xl">
                        <q-input 
                            class="q-mx-auto q-headline" 
                            align="center"
                            color="orange-8"
                            v-model="customer.otp" 
                            style="width:150px" 
                            maxlength="4"
                            key="otp"
                            type="text"  />
                        <br>
                        <span>Enter 4-digit number</span><br><br><br>
                        <q-btn 
                            @click="verifyOTP()" 
                            class="text-white bg-orange-8 text-weight-bold">
                            Verify
                        </q-btn>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12"><br><br>
                        <a href="" @click.prevent="getOTP()" class="q-body-2">Resend OTP</a><br> <br>
                        <a href="" @click.prevent="otpGot=false" class="text-negative q-body-2">Wrong Mobile Number ?</a>
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
    data(){
        return{
            otpGot:false,
        }
    },
    computed:{
            ...mapState({
            customer: state => state.Tiffin.user
        }),
    },
    methods:{
        getOTP(){
            const self = this
            this.$store.dispatch('Tiffin/getOTP',{
                customer : this.customer,
                callback:function(){
                    self.otpGot = true;
                }
            })    
        },
        verifyOTP(){
            const self = this
            this.$store.dispatch('Tiffin/verifyOTP',{
                customer:this.customer,
                callback:function(response){
                    self.$q.localStorage.set('customer_secret', response.data.remember_token)
                    self.$q.localStorage.set('customer',response.data)
                    if(response.data.name && response.data.location) // to setData in state
                        self.$router.push({path:'/customer'})
                    else
                        self.$router.push({path:'/register'})
                }
            })    
        },
        
    }
}
</script>

<style scoped>
 p {
    padding: 0 10px;
 }
 a {
    text-decoration: none;
    color:dodgerblue;
 }
 a:hover{
    text-decoration: underline;
 }
</style>
