import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        city: "",
        theater: "",
        show:"",
    },
    getters: {
        getCity: state => {
            return state.city;
        },
        getTheater: state => {
            return state.theater;
        },
        getShow: state => {
            return state.show;
        }
    },
    mutations: {
        changeCity (state, payload) {
            state.city = payload
        },
        changeTheater (state, payload) {
            state.theater = payload
        },
        changeShow (state, payload) {
            state.show = payload
        },
    },
    actions: {}
});
