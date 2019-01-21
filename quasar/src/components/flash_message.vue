<template>

<div class="row flex-center">
    <div class="text-center absolute-center z-top" v-if="flash_message">
     <q-slide-transition>
       <q-alert
        :color="flash_message.type"
        :icon="flash_message.icon"
        >
        {{ flash_message.message }}
        </q-alert>
        </q-slide-transition>
    </div>
</div>
  
</template>

<script>
export default {
    name:"flash",
    computed:{
        flash_message:function(){
            return this.$store.state.tiffin.flash_message
        }
    }
}
</script>

<style>

</style>
