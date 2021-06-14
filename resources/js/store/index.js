import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

export default new Vuex.Store({
    state: {
        user: null
    },

    mutations: {
        setUserData (state, userData) {
            state.user = userData
            localStorage.setItem('user', JSON.stringify(userData))
            axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`
        },

        clearUserData () {
            localStorage.removeItem('user')
            location.reload()
        }
    },

    actions: {
        login ({ commit }, credentials) {
            return axios
                .post('/login', credentials)
                .then(({ data }) => {
                    console.log(data);
                    if(data.status === "error"){
                        return data;
                    }else{
                        commit('setUserData', data);
                        if(this.state.user.user.is_admin == 1){
                            location.href= "/admin/home";
                        }else if(this.state.user.user.is_admin == 0){
                            location.href= "/home";
                        }
                    }
                })
        },
        register ({ commit }, credentials) {
            return axios
                .post('/register', credentials)
        },
        logout ({ commit }) {
            commit('clearUserData')
            location.href = "/login";
        }
    },

    getters : {
        isLogged: state => !!state.user,
        userName: state => state.user.user.name,
        userId: state => state.user.user.id,
        isAdmin: state => state.user.user.is_admin,
    }
})
