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
            <th>Login</th>
            <th>Phone</th>
            <th>Delivery</th>
            <th>Invoice</th>
            <th>Confirmed</th>
            <th>Add</th>
            <th>In status</th>
            <th class="statuses">Statuses</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in ordersStore.orders">
            <td>{{ order.order_id }} <div v-if="order.confirmed">
                <VChip small class="font-weight-medium" label color="success">
                  Confirmed
                </VChip>
              </div>
              <div v-else>
                <VChip small class="font-weight-medium" label color="error">
                  Not confirmed
                </VChip>
              </div>
            </td>
            <td>{{ order.order_source }}</td>
            <td>{{ order.delivery_fullname }}</td>
            <td>{{ order.email }}</td>
            <td>{{ order.user_login ? order.user_login : '---' }}</td>
            <td>{{ order.phone }}</td>
            <td>
              <VBtn small @click="showDeliveryDetails(order.order_id)" color="info">
                <span>
                  Show details
                </span>
              </VBtn>
              <div v-if="deliveryToggled && deliveryToggled == order.order_id">
                <p>{{ order.delivery_address }}</p>
                <p>{{ order.delivery_city }}</p>
                <p>{{ order.delivery_postcode }}</p>
                <p>{{ order.delivery_country_code }} - {{ order.delivery_country }}</p>
              </div>
            </td>
            <td>
              <VBtn small @click="showInvoiceDetails(order.order_id)" color="info">
                <span>
                  Show details
                </span>
              </VBtn>
              <div v-if="invoiceToggled && invoiceToggled == order.order_id">
                <p>{{ order.invoice_address }}</p>
                <p>{{ order.invoice_city }}</p>
                <p>{{ order.invoice_postcode }}</p>
                <p>{{ order.invoice_country_code }} - {{ order.invoice_country }}</p>
                <p>{{ order.invoice_company }} - {{ order.invoice_nip }}</p>
              </div>
            </td>
            <td>{{ formatDate(order.date_confirmed, true) }}</td>
            <td>{{ formatDate(order.date_add, true) }}</td>
            <td>{{ formatDate(order.date_in_status, true) }}</td>
            <td>
              Current : {{ order.name ? order.name : '---' }}
              <VBtn v-if="order.name && expandedId != order.order_id" small @click="getStatuses(order.order_id)"
                color="info">
                <span>
                  Load all
                </span>
              </VBtn>
              <div v-if="order.order_id == expandedId">
                <table class="table-min">
                  <th>
                  <td>Status</td>
                  <td>Data</td>
                  </th>
                  <tr v-for="status in expandedStatuses" :key="status.id">
                    <td>{{ status.name }}</td>
                    <td>{{ formatDate(status.created_at, false) }}</td>
                  </tr>
                </table>
              </div>
            </td>
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
import { onMounted, watch, ref } from 'vue-demi'
import axios from 'axios';
export default {
  setup() {
    const ordersStore = useOrdersStore()
    const deliveryToggled = ref(null);
    const invoiceToggled = ref(null);
    const expandedStatuses = ref(null);
    const expandedId = ref(null);
    const statusColor = {
      0: 'success',
      1: 'error',
    }
    function formatDate(date, unix) {
      const newDate = new Date(unix ? date * 1000 : date);
      const month = newDate.getMonth() + 1;
      const day = newDate.getDate();
      const year = newDate.getFullYear();
      return `${day}-${month}-${year}`
    }
    function showDeliveryDetails(id) {
      if (deliveryToggled.value === id) {
        deliveryToggled.value = null;
        return;
      }
      deliveryToggled.value = id;
    }
    function showInvoiceDetails(id) {
      if (invoiceToggled.value === id) {
        invoiceToggled.value = null;
        return;
      }
      invoiceToggled.value = id;
    }

    async function getStatuses(order_id) {
      try {
        const response = await axios.get(`/api/status?order_id=${order_id}`);
        this.expandedStatuses = response.data
        this.expandedId = order_id
      } catch (error) {
        console.error(error);
      }
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
      showDeliveryDetails,
      deliveryToggled,
      expandedId,
      showInvoiceDetails,
      invoiceToggled,
      formatDate,
      getStatuses,
      expandedStatuses,
      // icons
      icons: {
        mdiSquareEditOutline,
        mdiDotsVertical,
      },
    }
  },
}
</script>
<style lang="scss">
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
  max-width: 180px;

  p {
    margin: 0;
  }
}

.styled-table th.statuses {
  min-width: 300px;
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

.styled-table {
  .table-min {

    th,
    td {
      padding: 6px 7px;
    }
  }
}
</style>