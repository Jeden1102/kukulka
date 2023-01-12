<template>
  <v-row>
    <v-col cols="12">
      <dashboard-datatable></dashboard-datatable>
    </v-col>
  </v-row>
</template>

<script>

import { useUserStore} from '../../store/user';
import DashboardDatatable from './DashboardDatatable.vue'

export default {
  components: {
    DashboardDatatable,
  },
  setup() {
    const userStore = useUserStore();
      return{
        userStore
    }
  },
}
</script>
