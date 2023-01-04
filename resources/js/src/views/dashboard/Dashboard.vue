<template>
  <v-row>
    <v-col cols="12">
      <dashboard-datatable></dashboard-datatable>
    </v-col>
  </v-row>
</template>

<script>

import DashboardDatatable from './DashboardDatatable.vue'

export default {
  components: {
    DashboardDatatable,
  },
  setup() {
    return {

    }
  },
}
</script>
