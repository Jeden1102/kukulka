import { defineStore } from 'pinia'
import axios from 'axios'
export const useUserStore = defineStore('user', {
    state: () => ({ user: null, users: null }),
    actions: {
        getUsers() {
            axios.get('/api/users').then((res) => {
                this.users = res.data
            }).catch(err => {
                console.log(err)
            })
        }
    }
})