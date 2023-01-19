<template>
  <v-card>
    <div class="table-wrapper">
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Source</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Confirmed</th>
            <th>Add</th>
            <th>In status</th>
            <th>Created</th>
            <th>Updated</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in ordersStore.orders">
            <td>{{ order.order_id }}</td>
            <td>{{ order.order_source }}</td>
            <td>{{ order.delivery_fullname }}</td>
            <td>{{ order.email }}</td>
            <td>{{ formatDate(order.date_confirmed, true) }}</td>
            <td>{{ formatDate(order.date_add, true) }}</td>
            <td>{{ formatDate(order.date_in_status, true) }}</td>
            <td>{{ formatDate(order.created_at, false) }}</td>
            <td>{{ formatDate(order.updated_at, false) }}</td>
          </tr>
        </tbody>

      </table>
      <VPagination v-model="ordersStore.current_page" :length="ordersStore.last_page" :total-visible="7" />
    </div>

  </v-card>
</template>

<script>
import { mdiSquareEditOutline, mdiDotsVertical } from '@mdi/js'
import { useOrdersStore } from '../../store/orders'
import { onMounted, watch } from 'vue-demi'

export default {
  setup() {
    const ordersStore = useOrdersStore()
    const statusColor = {
      0: 'success',
      1: 'error',
    }
    function formatDate(date, unix) {
      const newDate = new Date(unix ? date * 1000 : date);
      const month = newDate.toLocaleString('default', { month: 'short' });
      const day = newDate.getDay();
      const year = newDate.getFullYear();
      return `${day} ${month} ${year}`
    }

    watch(() => ordersStore.current_page, (n) => console.log(ordersStore.getOrders(n)));

    onMounted(() => {
      ordersStore.getOrders(1)
    })

    return {
      status: {
        0: 'Active',
        1: 'Distactive',
      },
      statusColor,
      ordersStore,
      formatDate,
      // icons
      icons: {
        mdiSquareEditOutline,
        mdiDotsVertical,
      },
    }
  },
}
</script>
<style>
.table-wrapper {
  overflow-x: scroll;
}

.styled-table {
  border-collapse: collapse;
  margin: 25px 0;
  font-size: 0.9em;
  font-family: sans-serif;
  min-width: 400px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  width: 100%;
  min-width: 1000px;
}

.styled-table thead tr {
  background-color: #009879;
  color: #ffffff;
  text-align: left;
}

.styled-table th,
.styled-table td {
  padding: 12px 15px;
}

.styled-table tbody tr {
  border-bottom: 1px solid #dddddd;
}

.styled-table tbody tr:nth-of-type(even) {
  background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
  border-bottom: 2px solid #009879;
}

.user-actions {
  display: flex;
  gap: 8px;
}
</style>