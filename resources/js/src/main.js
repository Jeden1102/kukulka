import '@/plugins/vue-composition-api'
import '@resources/sass/styles/styles.scss'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'
import { createPinia, PiniaVuePlugin } from 'pinia'

Vue.use(PiniaVuePlugin)
const pinia = createPinia()
Vue.config.productionTip = false

new Vue({
    router,
    store,
    pinia,
    vuetify,
    render: h => h(App),
}).$mount('#app')