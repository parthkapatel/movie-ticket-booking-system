/*require('./bootstrap');

import Vue from "vue";
import VueRouter from 'vue-router'
import store from './store/index'

Vue.use(VueRouter);


import routes from './route'
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes
})

new Vue({
    el: '#app',
    router,
    store,
});*/
require('./bootstrap');


import Vue from 'vue'
import App from './components/app.vue'
import router from './router'
import store from './store'

Vue.config.productionTip = false

new Vue({
    el: '#app',
    router,
    store,
    created () {
        const userInfo = localStorage.getItem('user')
        if (userInfo) {
            const userData = JSON.parse(userInfo)
            this.$store.commit('setUserData', userData)
        }
        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response.status === 401) {
                    this.$store.dispatch('logout')
                }
                return Promise.reject(error)
            }
        )
    },
    render: h => h(App)
}).$mount('#app')

