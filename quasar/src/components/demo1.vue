<template>
<q-page padding>
<q-card inline class="full-width">
    <q-card-title>
    <q-item>
    <q-item-main>
      <q-item-tile label>Lunch</q-item-tile>
      <q-item-tile sublabel>Subhead</q-item-tile>
    </q-item-main>
  </q-item>
    </q-card-title>
    
    <q-card-main>
         <q-item>
        Moong Sebut, Green Veg, Plain Rice, Tava Roti, Green Salad
         </q-item>
    </q-card-main>
     <q-card-separator />
    <q-card-action class="flex flex-center">
        <q-btn round dense color="positive" >+</q-btn>
        <h6 flat color="primary" size="md" class="q-pl-md">Quantity</h6>
        <q-btn round dense color="grey-5" class="q-ml-md">-</q-btn>
    </q-card-action>
</q-card>
<div class="text-center q-mt-md"> <q-btn outline color="positive" label="Order"/></div>   
</q-page>
</template>
