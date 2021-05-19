require('./bootstrap');

import Vue from "vue";
import VueRouter from 'vue-router'
import store from './store/index'

/*
import Vuex from "vuex";
Vue.use(Vuex);


const store = new Vuex.Store({
    state: {
        city: "",
        theater: "",
    },
    getters: {
        getCity: state => {
            return state.city;
        },
        getTheater: state => {
            return state.theater;
        }
    },
    mutations: {
        changeCity (state, payload) {
            state.city = payload
        },
        changeTheater (state, payload) {
            state.theater = payload
        },
    },
    actions: {}
});
*/

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
