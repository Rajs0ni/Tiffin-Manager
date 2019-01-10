<template>
<div class="row">
    <div class="col-12">
        <p>{{flash_message}}</p>
        <q-list highlight separator>
            <div class="col-12"  v-for="order in orders" :key="order.index" >
                <q-list-header v-if="order.key ==0 ">Undelivered</q-list-header>
                 <q-list-header v-else>Delivered</q-list-header>
                    <q-item highlight  v-for="record in order.value" :key="record.index">
                        <q-item-side left color="grey-10">
                            <q-item-tile label>Order ID&nbsp;:&nbsp;<span>#{{ record.id}}</span></q-item-tile>
                            <q-item-tile label>Quantity&nbsp;:&nbsp;<span >{{ record.no_of_tiffin}}</span></q-item-tile>
                        </q-item-side>
                        <q-item-main class="text-center" >
                            <span style="color:grey">{{ record.created_at | parseDate}}</span>
                        </q-item-main>
                        <q-item-side right><q-btn
                                        outline
                                        size="sm"
                                        icon="fas fa-truck"
                                        :color="[record.status ? 'positive' : 'negative']"
                                        @click="deliverOrder(record.id)"></q-btn>
                        </q-item-side>
                    </q-item>
            </div>
        </q-list>
    </div>
</div>
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
        },
        flash_message()
        {
            return this.$store.state.tiffin.flash_message
        }
    },
    mounted(){
         this.$store.dispatch('tiffin/setProviderOrders')
    },
    methods:{
        deliverOrder(id)
        {
           
            this.$store.dispatch('tiffin/processOrder',{
            order_id:id
        }) 
          this.$store.dispatch('tiffin/setProviderOrders')
        }
    }
}
</script>

<style>

</style>
