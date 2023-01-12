import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
Vue.use(VueRouter)
import { useUserStore } from '../store/user'

const routes = [{
        path: '/',
        redirect: 'dashboard',
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () =>
            import ('@/views/dashboard/Dashboard.vue'),
    },
    {
        path: '/pages/login',
        name: 'pages-login',
        component: () =>
            import ('@/views/pages/Login.vue'),
        meta: {
            layout: 'blank',
        },
    },
    {
        path: '/pages/register',
        name: 'pages-register',
        component: () =>
            import ('@/views/pages/Register.vue'),
        meta: {
            layout: 'blank',
        },
    },
    {
        path: '/error-404',
        name: 'error-404',
        component: () =>
            import ('@/views/Error.vue'),
        meta: {
            layout: 'blank',
        },
    },
    {
        path: '*',
        redirect: 'error-404',
    },
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
})

router.beforeEach((to, from, next) => {
    if (to.name === 'pages-login' || to.name === 'pages-register') {
        if (localStorage.getItem('user') != null) {
            router.push({ name: 'dashboard' })
        }
    }
    if (to.name === 'dashboard') {
        if (localStorage.getItem('user') == null) {
            router.push({ name: 'pages-login' })
        }
        axios.post('/api/auth', { remember_token: localStorage.getItem('user') }).then(res => {
            if (res.data.length > 0) {
                useUserStore().user = res.data
                next();
            } else {
                router.push({ name: 'pages-login' })
            }
        }).catch(err => {
            router.push({ name: 'pages-login' })
        })
    }
    return next()
})

export default router