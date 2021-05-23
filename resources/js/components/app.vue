<template>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">Movie Booking</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto" v-if="!isLogged">
                    <li class="nav-item active">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li class="nav-item active">
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto" v-if="isLogged">

                    <!-- users menu   -->
                    <li class="nav-item active" v-if="!isAdmin">
                        <router-link class="nav-link" to="/home" v-if="isLogged">Movie List</router-link>
                    </li>
                    <li class="nav-item active" v-if="!isAdmin">
                        <router-link class="nav-link" to="/user/booked" v-if="isLogged">Booked Tickets</router-link>
                    </li>
                    <!-- end user menu -->

                    <!-- admin menu -->
                    <li class="nav-item" v-if="isAdmin">
                        <router-link class="nav-link" to="/admin/home/">
                            Dashboard
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="isAdmin">
                        <router-link class="nav-link" to="/city/create/">
                            Manage Cities
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="isAdmin">
                        <router-link class="nav-link" to="/theater/create/">
                            Manage Theaters
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="isAdmin">
                        <router-link class="nav-link" to="/cast/create/">
                            Manage Casts
                        </router-link>
                    </li>
                    <li class="nav-item dropdown" v-if="isAdmin">
                        <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Manage Movies
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                            <router-link class="dropdown-item" to="/movie/create/">
                                Add/View Movies
                            </router-link>
                            <router-link class="dropdown-item" to="/theater/assign/create/">
                                Assign Movies
                            </router-link>
                            <router-link class="dropdown-item" to="/cast/assign/create/">
                                Assign Casts
                            </router-link>
                            <router-link class="dropdown-item" to="/bookTicket/booked/">
                                Booked Tickets
                            </router-link>
                        </div>
                    </li>
                    <!-- end admin -->

                    <li class="nav-item dropdown" v-if="isLogged">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ userName }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" @click="logout()" style="cursor: pointer;"> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container py-5">
            <router-view/>
        </div>
        <footer-section />
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import footerSection from "./footerSection";
export default {
    name: "app",
    computed: {
        ...mapGetters([
            'isLogged',
            'userName',
            'isAdmin',
        ])
    },
    components: {
        footerSection,
    },
    data: function () {
        return {
            movies: [],
        }
    },
    methods: {
        logout() {
            this.$store.dispatch('logout')
        },
    },

}
</script>

<style scoped>

</style>
