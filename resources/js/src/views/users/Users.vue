<template>
  <v-row>
    <v-col cols="12">
      <users-datatable></users-datatable>
    </v-col>
  </v-row>
</template>

<script>

import { useUserStore } from '../../store/user';
import UsersDatatable from './UsersDatatable.vue'

export default {
  components: {
    UsersDatatable,
  },
  setup() {
    const userStore = useUserStore();
    return {
      userStore
    }
  },
}
</script>
