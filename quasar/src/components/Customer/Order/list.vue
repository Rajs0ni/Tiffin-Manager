<template>
<div class="row">
    <div class="col-12">
        <q-list highlight separator>
            <div class="col-12"  v-for="order in orders" :key="order.index" >
                <q-list-header v-if="order.key == 0" color="negative">Undelivered</q-list-header>
                 <q-list-header v-else color="positive">Delivered</q-list-header>
                    <q-item highlight  v-for="record in order.value" :key="record.index">
                        <q-item-main>
                            <q-item-tile label>Order ID&nbsp;:&nbsp;<span>#{{ record.id }}</span></q-item-tile>
                            <q-item-tile label>Quantity&nbsp;:&nbsp;<span >{{ record.no_of_tiffin }}</span></q-item-tile>
                        </q-item-main>
                        <q-item-side right> 
                            <span style="color:grey">{{ record.created_at | parseDate}}</span>
                        </q-item-side>
                    </q-item>
            </div>
        </q-list>
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
    filters:{
        status(value){
            return value?'Delivered':'Pending';
        }
    },
    mounted(){
        this.$store.dispatch('tiffin/setCustomerOrders')
    }
}
</script>
