import { defineStore } from 'pinia'
import axios from 'axios'
export const useOrdersStore = defineStore('orders', {
    state: () => ({ orders: null }),
    actions: {
        getOrders() {
            axios.get('/api/orders').then((res) => {
                this.orders = res.data
            }).catch(err => {
                console.log(err)
            })
        }
    }
})