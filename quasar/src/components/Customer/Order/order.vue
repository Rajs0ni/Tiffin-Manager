<template>
  
    <q-card class="q-mx-sm q-mt-xl">
      <q-card-title class="bg-info text-white">
          Order Id : 1
      </q-card-title>    
        <q-card-separator />
      
      <q-card-main>
          <q-item>
            <q-item-main class="on-right">Tiffin Plan :</q-item-main>
            <q-item-side class="on-left">Light Bite</q-item-side>
          </q-item>
          <q-card-separator />
          <q-item>
            <q-item-main class="on-right">Quantity :</q-item-main>
            <q-item-side class="on-left">1</q-item-side>
          </q-item>
           <q-card-separator />
           <q-item>
            <q-item-main class="on-right">Price :</q-item-main>
            <q-item-side class="on-left">Rs. 65</q-item-side>
          </q-item>
          <q-card-separator />
           <q-item>
            <q-item-main class="on-right">Date</q-item-main>
            <q-item-side class="on-left">18/01/2019</q-item-side>
          </q-item>
          <q-card-separator />
           <q-item>
            <q-item-main class="on-right">Total Amount</q-item-main>
            <q-item-side class="on-left">Rs. 65</q-item-side>
          </q-item>
          <q-card-separator />
           <q-item>
            <q-item-main class="on-right">Status</q-item-main>
            <q-item-side class="on-left">Pending</q-item-side>
          </q-item>
          
      </q-card-main>
      <q-card-separator />
      <q-card-actions>
        <q-btn flat>Action 1</q-btn>
        <q-btn flat>Action 2</q-btn>
      </q-card-actions>
    </q-card>
 
</template>

<script>
export default {
  data: () => ({

    visibleColumns: ['desc', 'fat', 'carbs', 'protein', 'sodium', 'calcium', 'iron'],
    separator: 'horizontal',
    filter: ''
  }),
  mounted(){
    if(this.$route.params.id)
    {
      alert(this.$route.params.id);
    }
  }
}
</script>