<template>
    <div class="row">
        <div class="col-12" v-if="orders">
            <q-list no-border>
                <div class="col-12"  v-for="order in orders" :key="order.index" >
                    <q-list-header v-if="order.key == 0" style="color:red">Undelivered</q-list-header>
                    <q-list-header v-else style="color:green">Delivered</q-list-header>
                        <q-item highlight separator class="cursor-pointer"  v-for="record in order.value" :key="record.index" @click.native="getOrder(record)">
                            <q-item-main>
                                <q-item-tile label>Order ID&nbsp;:&nbsp;<span>{{ record.id }}</span></q-item-tile>
                                <q-item-tile label>Quantity&nbsp;:&nbsp;<span >{{ record.no_of_tiffin }}</span></q-item-tile>
                            </q-item-main>
                            <q-item-side right> 
                                <span style="color:grey">{{ record.created_at | parseDate}}</span>
                            </q-item-side>
                        </q-item>
                        <q-card-separator />
                </div>
            </q-list>
        </div>
        <div v-else class="col-12 text-center">
        <p class="text-weight-medium q-mt-xl text-warning">
            No orders yet. <a href="" @click.prevent="$router.push('/customer')"> Order Now.</a>
            </p>
        </div>
    </div>
</template>


<script>
export default {
    computed:{
        orders(){
            return this.$store.state.tiffin.customer.orders
        }
    },
    methods:{
        getOrder(order){
            this.$router.push(`/customer/orders/${order.id}`)
        }
    },
    mounted(){
        this.$store.dispatch('tiffin/setCustomerOrders',{
            user_id:2
        })
    }
}
</script>