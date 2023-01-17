<template>
  <v-card>
    <div class="table-wrapper">
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in userStore.users">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ formatDate(user.created_at) }}</td>
            <td>{{ formatDate(user.updated_at) }}</td>
            <td>
              <VChip v-if="!user.root">
                <VIcon start size="18" icon="mdi-account-outline" />
                Base user
              </VChip>
              <VChip v-else>
                <VIcon start size="18" icon="mdi-account-outline" />
                Root user
              </VChip>
            </td>
            <td>
              <div v-if="user.active">
                <VChip small class="font-weight-medium" label color="success">
                  Active
                </VChip>
              </div>
              <div v-else>
                <VChip small class="font-weight-medium" label color="error">
                  Distactive
                </VChip>
              </div>
            </td>
            <td class="user-actions">
              <VBtn @click="activateUser(user.id)" v-if="!user.active" color="success">
                <span>
                  Activate
                </span>
              </VBtn>
              <VBtn @click="makeRoot(user.id)" v-if="!user.root" color="info">
                <span>
                  Make root
                </span>
              </VBtn>
              <VBtn v-if="!user.root" @click="deleteUser(user.id)" color="error">
                Delete
              </VBtn>
            </td>
          </tr>
        </tbody>

      </table>

    </div>

  </v-card>
</template>

<script>
import { mdiSquareEditOutline, mdiDotsVertical } from '@mdi/js'
import { useUserStore } from '../../store/user'
import { onMounted } from 'vue-demi'
import avatar2 from '../../assets/images/avatars/1.png'
import avatar3 from '../../assets/images/avatars/2.png'
import axios from 'axios'
export default {
  setup() {
    const userStore = useUserStore()
    const statusColor = {
      0: 'success',
      1: 'error',
    }
    function formatDate(date) {
      const newDate = new Date(date);
      const month = newDate.toLocaleString('default', { month: 'short' });
      const day = newDate.getDay();
      const year = newDate.getFullYear();
      return `${day} ${month} ${year}`
    }
    function deleteUser(id) {
      axios.delete(`api/user/${id}`).then(res => {
        userStore.getUsers()
      }).catch(err => {
        console.log(err)
      })
    }
    function activateUser(id) {
      axios.post(`api/userEdit`, {
        id: id,
        active: 1,
      }).then(res => {
        userStore.getUsers()
      }).catch(err => {
        console.log(err)
      })
    }
    function makeRoot(id) {
      axios.post(`api/userEdit`, {
        root: 1,
        id: id
      }).then(res => {
        userStore.getUsers()
      }).catch(err => {
        console.log(err)
      })
    }
    onMounted(() => {
      userStore.getUsers()
    })

    return {

      status: {
        0: 'Active',
        1: 'Distactive',
      },
      statusColor,
      deleteUser,
      userStore,
      formatDate,
      activateUser,
      makeRoot,
      avatar2,
      avatar3,
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