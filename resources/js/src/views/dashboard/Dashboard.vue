<template>
  <v-row>
    <h2>Filters</h2>
    <div class="filters__box">
      <div class="filter">
        <label for="">Status</label>
        <VCombobox @change="updateFilters" v-model="ordersStore.filters.status" :items="statuses" />
      </div>
      <div class="filter">
        <label for="">Date range</label>
        <date-range-picker ref="picker" :locale-data="{ firstDay: 1, format: 'dd-mm-yyyy HH:mm:ss' }"
          singleDatePicker="range" :showWeekNumbers="true" :showDropdowns="true" :autoApply="true"
          v-model="ordersStore.filters.date" @update="updateFilters">
          <template v-slot:input="picker" style="min-width: 350px;">
            {{ formatDate(picker.startDate) }} - {{ formatDate(picker.endDate) }}
          </template>
        </date-range-picker>
      </div>
    </div>

    <v-col cols="12">
      <dashboard-datatable></dashboard-datatable>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios';
import { onMounted, ref } from 'vue-demi'

import { useUserStore } from '../../store/user';
import { useOrdersStore } from '../../store/orders';
import DashboardDatatable from './DashboardDatatable.vue'
import DateRangePicker from 'vue2-daterange-picker'
//you need to import the CSS manually
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css'
export default {
  components: {
    DashboardDatatable,
    DateRangePicker
  },
  setup() {
    const userStore = useUserStore();
    const ordersStore = useOrdersStore();
    const statuses = ref([])
    function updateValues() {
      console.log(ordersStore)
    }
    function formatDate(date) {
      const newDate = new Date(date);
      const month = newDate.getMonth() + 1;
      const day = newDate.getDate();
      const year = newDate.getFullYear();
      return `${day}-${month}-${year}`
    }
    function updateFilters() {
      ordersStore.getOrders()
      console.log("ok")
    }
    function getStatuses() {
      axios.get('/api/status/all').then(res => {

        let values = res.data.map(obj => obj.name);
        statuses.value = values;
        console.log(values)
      }).catch(err => {
        console.log(err)
      })
    }
    onMounted(() => {
      getStatuses()
    })
    return {
      userStore,
      updateValues,
      formatDate,
      statuses,
      ordersStore,
      updateFilters
    }
  },
}
</script>
<style lang="scss">
.filters__box {
  margin-top: 24px;
  display: flex;
  gap: 48px;

  .filter {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
  }
}
</style>