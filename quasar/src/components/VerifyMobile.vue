<template>
    <div>
        <div class="row window-height window-width text-center">
            <div class="col-12">
                <div class="row q-mt-xl">
                    <div class="col-12">
                        <p class="q-title q-px-lg text-weight-bold">Please enter the OTP to verify your account</p>
                        <p class="q-subheading">A OTP has been sent to <b>{{ customer.mobile || number}}</b></p>
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
                            type="text"  />
                        <br>
                        <span>Enter 4-digit number</span><br>
                        <q-btn @click="verifyOTP()" class="q-mt-xl bg-orange-8 text-white text-weight-bold">
                            Verify
                        </q-btn>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12"><br><br>
                        <a href="#" class="q-body-2">Resend OTP</a><br>
                        <br><a href="" @click.prevent="$router.push('/login')" class="text-negative q-body-2">Wrong Mobile Number ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex';

export default {
    data(){
        return{
                number :''
        }
        },
    mounted(){
            var customer = JSON.parse(this.$q.localStorage.get.item('customer'))
            this.number = customer['mobile']
        },
    computed:{
            ...mapState({
            customer: state => state.Tiffin.customer.detail
        }),
    },
    methods:{
            verifyOTP(){
                this.$store.dispatch('Tiffin/verifyOTP',{
                customer:this.customer
            })
        }
    }
}
</script>

<style>
 a {
    text-decoration: none;
    color:dodgerblue;
}
a:hover{
    text-decoration: underline;
}
</style>
