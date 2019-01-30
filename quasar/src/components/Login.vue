<template>
    <div>
        <div class="row window-height window-width items-center text-center">
            <div class="col-12">
                <div class="row">
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
                        <q-input prefix="+91-" v-model="number" class="q-pa-none" placeholder="Your Mobile Number..." type="number"  />
                    </div>
                    <div class="col-1"></div>
                </div>
                <br><br>
                <div class="row text-white">
                    <div class="col-12">
                        <q-btn @click.native="getOTP()" class="bg-green">Get OTP</q-btn>
                    </div>
                </div>
            </div>
        </div>   
    </div> 
</template>

<script>
export default {

    data(){
        return{
            number:''
        }
    },
    methods:{
        getOTP(){
            
        }
    }

}
</script>

<style>

</style>
