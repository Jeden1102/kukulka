import { defineStore } from 'pinia'
import axios from 'axios'
export const useOrdersStore = defineStore('orders', {
    state: () => ({
        orders: null,
        current_page: 0,
        last_page: 0,
        filters: {
            date: {
                startDate: Date.now() - 604800000,
                endDate: Date.now()
            },
            status: null
        }
    }),
    actions: {
        getOrders(page) {
            let filtersString = '';
            if (this.filters.status) {
                filtersString += `&status=${this.filters.status}`
            }
            if (this.filters.date.startDate || this.filters.date.endDate) {
                filtersString += `&startDate=${new Date(this.filters.date.startDate).getTime()}&endDate=${new Date(this.filters.date.endDate).getTime()}`
            }
            console.log(`/api/orders?page=${this.current_page}${filtersString}`)

            axios.get(`/api/orders?page=${this.current_page}${filtersString}`).then((res) => {
                this.orders = res.data.data
                this.current_page = res.data.current_page
                this.last_page = res.data.last_page
                console.log(res)
                console.log(`/api/orders?page=${this.current_page}${filtersString}`)
            }).catch(err => {
                console.log(err)
            })
        }
    }
})