<template>
    <q-alert
    v-if="true"
    color="positive"
    icon="done"
    appear
    :actions="[{ label: 'Dismiss', handler: () => { visible = false } }]"
    class="q-mb-sm"
  >
   hello
  </q-alert>
</template>

<script>
export default {
    data(){
        return{
            visible:true
        }
    },
    computed:{
        flash_message:function(){
            return this.$store.state.tiffin.flash_message
        }
    }
}
</script>

<style>

</style>
