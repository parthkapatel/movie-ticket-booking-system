require('./bootstrap');

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
});
