<template>
    <div>   
     <q-collapsible :icon="title=='Lunch' ? 'wb_sunny': 'brightness_3'"  :label="title" opened >
        <q-card inline class="fit" v-if="menu">
          <q-card-main>
            <q-item class="text-weight-light">
                  {{ menu.desc }}
            </q-item>     
          </q-card-main>
          <q-card-separator />
        </q-card>
        <div v-else class="col-12 text-center">
            <p class="text-weight-medium q-mt-md text-negative">No menu for the day.</p>
        </div>
    </q-collapsible>
</div>
</template>

<script>
export default {
props:['menu','title'],
}
</script>

<style>

</style>
