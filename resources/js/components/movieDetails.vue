<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <b>{{ movie.title }}</b>
            </div>
            <div class="card-body">
                <p class="card-text">Movie Overview : {{ movie.overview }}</p>
                <p class="card-text">Movie Release Year : {{ movie.release_year }}</p>
            </div>
            <div class="card-footer">
                <h5 class="card-text">Cast Member : </h5>
                <div class="container">
                    <div class="d-flex bd-highlight flex-wrap">
                        <div class="card border-dark m-3 flex-fill" v-for="(cast,index) in casts" :key="index">
                            <div class="card-body">
                                <h5 class="card-title">{{ cast.name }}</h5>
                                <p>{{ cast.bio }}</p>
                                <router-link :to="'/user/cast/'+cast.id" class="btn btn-primary">Visit Profile
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <h5>Book Tickets</h5>
                <form class="mt-3 form-inline" id="addCastMovie">
                    <div class="form-group mb-2">
                        <label class="mx-2">Select City : </label>
                        <select v-model="city_id" class="form-control" @change="getTheaters">
                            <option v-for="(city,index) in cities" :key="index" :value="city.id">{{
                                    city.city_name
                                }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group mx-sm-3 mb-2" v-if="cityBool">
                        <label class="mx-2">Select Theater : </label>
                        <select v-model="theater_id" class="form-control" @change="getShows">
                            <option v-for="(theater,index) in theaters" :key="index" :value="theater.id">
                                {{ theater.theater_name }}
                            </option>
                        </select>
                    </div>
                    <span class="alert alert-danger mx-2 mb-2" v-if="error">{{ error }}</span>
                </form>
                <div class="container">
                    <div class="d-flex bd-highlight justify-content-center flex-wrap">
                        <router-link  v-for="(show,index) in shows" :key="index" to="/bookTicket"
                                     class="links flex-fill">
                            <div @click="setStateValue(show)" class=" border p-2 m-2 text-center" style="border-radius: 5px;">
                                {{ show }}
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "movieDetails",
    data: function () {
        return {
            movie: {
                id: "",
                title: "",
                overview: "",
                release_year: "",
            },
            casts: [],
            city: [],
            cities: [],
            theaters: [],
            shows: [],
            city_id: "",
            theater_id: "",
            cityBool: false,
            error: "",
        }
    },
    methods: {
        getMovie: function () {
            axios.get('/api/movie/' + this.$route.params.id)
                .then(response => {
                    console.log(response);
                    this.movie.id = response.data.id;
                    this.movie.title = response.data.title;
                    this.movie.overview = response.data.overview;
                    this.movie.release_year = response.data.release_year;
                    this.getCasts(response.data.id);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getCasts: function (id) {
            axios.get('/api/castMovie/' + id)
                .then(response => {
                    this.casts = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getTheaters: function () {
            axios.get('/api/theater/getTheater/' + this.city_id)
                .then(response => {
                    this.theaters = response.data
                    if (this.theaters.length > 0) {
                        this.cityBool = true;
                        this.error = "";
                    } else if (this.city_id) {
                        this.cityBool = false;
                        this.shows = [];
                        this.error = "No Theater Found"
                    }
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getCities: function () {
            axios.get('/api/city/get')
                .then(response => {
                    this.cities = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getShows: function () {
            axios.get('/api/assign/movieShow/' + this.city_id + '/' + this.theater_id)
                .then(response => {
                    this.shows = response.data[0].runtime.split("|");
                })
                .catch(error => {
                    console.log(error);
                })
        },
        setStateValue:function (show) {
            const thisValue = this;
            const cities = this.cities.filter(function (elem) {
                if (elem.id === thisValue.city_id) return elem;
            });
            const theaters = this.theaters.filter(function (elem) {
                if (elem.id === thisValue.theater_id) return elem;
            });
            const city = cities[0];
            const theater = theaters[0];
            sessionStorage.setItem("city_id",city.id);
            sessionStorage.setItem("city_name",city.city_name);
            sessionStorage.setItem("theater_id",theater.id);
            sessionStorage.setItem("theater_name",theater.theater_name);
            sessionStorage.setItem("movie_id",this.movie.id);
            sessionStorage.setItem("movie_name",this.movie.title);
            sessionStorage.setItem("show",show);/*
            this.$store.commit("changeCity",this.city_id);
            this.$store.commit("changeTheater",this.theater_id);
            this.$store.commit("changeShow",show);*/
        }
    },
    created() {
        this.getMovie();
        this.getCities();
        this.getTheaters();
    }
}
</script>

<style scoped>
.links {
    color: black;
    text-decoration: none;
}
</style>
