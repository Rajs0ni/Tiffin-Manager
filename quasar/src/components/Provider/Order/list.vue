<template>
<div class="row" >
    <div class="col-12" v-if="orders">
        <q-list highlight no-border>
            <div class="col-12"  v-for="order in orders" :key="order.index" >
                <q-list-header v-if="order.key ==0" style="color:red">Undelivered</q-list-header>
                 <q-list-header v-else style="color:green">Delivered</q-list-header>
                    <q-item highlight  class="cursor-pointer" v-for="record in order.value" :key="record.index" @click.native="getOrder(record)">
                        <q-item-side left color="grey-10">
                            <q-item-tile label>Order ID&nbsp;:&nbsp;<span>{{ record.id }}</span></q-item-tile>
                            <q-item-tile label>Quantity&nbsp;:&nbsp;<span >{{ record.no_of_tiffin }}</span></q-item-tile>
                        </q-item-side>
                        <q-item-main class="text-center" >
                            <span style="color:grey">{{ record.created_at | parseDate}}</span>
                        </q-item-main>
                        <q-item-side right><q-btn
                                        outline
                                        size="sm"
                                        icon="fas fa-truck"
                                        :color="[record.status ? 'positive' : 'negative']"
                                        @click.native.stop="deliverOrder(record.id)"></q-btn>
                        </q-item-side>
                    </q-item>
            </div>
        </q-list>
    </div>
    <div v-else class="col-12 text-center">
        <p class="text-weight-medium q-mt-xl text-warning">
           No orders yet.
        </p>
    </div>
</div>
</template>

<script>

export default {
    computed:{
        orders(){
            return this.$store.state.tiffin.provider.orders
        },
    },
    mounted(){
      this.getOrders();
    },
    methods:{
        getOrders(){
            this.$store.dispatch('tiffin/setProviderOrders',{
            user_id:1
            })
        },
        getOrder(order){
            this.$router.push(`/provider/orders/${order.id}`)
        },
        deliverOrder(id)
        {
            this.$store.dispatch('tiffin/processOrder',{
            order_id:id
            }).then(()=>{
                this.getOrders()
            })
        }
    }
}
</script>

<style>

</style>
