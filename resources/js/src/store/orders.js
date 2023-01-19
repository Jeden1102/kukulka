import { defineStore } from 'pinia'
import axios from 'axios'
export const useOrdersStore = defineStore('orders', {
    state: () => ({ orders: null, current_page: 0, last_page: 0, }),
    actions: {
        getOrders(page) {
            axios.get(`/api/orders?page=${page}`).then((res) => {
                this.orders = res.data.data
                this.current_page = res.data.current_page
                this.last_page = res.data.last_page
            }).catch(err => {
                console.log(err)
            })
        }
    }
})