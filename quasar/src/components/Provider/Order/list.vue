<template>
    <q-list highlight separator>
        <q-item v-for="order in orders" :key="order.index">
            <q-item-main>
                <q-item-tile  label>Order ID&nbsp;:&nbsp;<span >{{ order.id}}</span></q-item-tile>
                <q-item-tile label>Status&nbsp;:&nbsp;<span >{{ order.status}}</span></q-item-tile>
            </q-item-main>
            <q-item-side right>{{order.created_at}}</q-item-side>
        </q-item>
    </q-list>
</template>

<script>

export default {
    data(){
        return{

        }
    },
    computed:{
        orders(){
            return this.$store.state.tiffin.provider.orders
        }
    },
    mounted(){
         this.$store.dispatch('tiffin/setProviderOrders')
    }
}
</script>

<style>

</style>
