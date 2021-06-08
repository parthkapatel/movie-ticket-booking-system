<template>
    <div class="container">
        <div class="card" v-if="!isLoading">
            <div class="card-header">
                <h3><b>{{ movie.title }}</b></h3>
            </div>
            <img class="card-img-top" width="500px" height="350px" :src="movie.image_path" :alt="movie.title">
            <div class="card-body">
                <p class="card-text"><b>Movie Release Year :</b> {{ movie.release_year }}</p>
                <p class="card-text"><b>Movie Overview :</b> {{ movie.overview }}</p>
            </div>
            <div class="card-footer">
                <h5 class="card-text"><b>Cast Member :</b></h5>
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
            <div class="container" v-if="cityData">
                <h5><b>Book Tickets</b></h5>
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
                    <div class="form-group mx-2 mb-2" v-if="cityBool">
                        <label class="mx-2">Select Theater : </label>
                        <select v-model="theater_id" class="form-control" @change="getShows">
                            <option v-for="(theater,index) in theaters" :key="index" :value="theater.id">
                                {{ theater.theater_name }}
                            </option>
                        </select>
                    </div>
                    <span class="alert alert-danger mx-2 mb-2" v-if="error">{{ error }}</span>
                </form>
                <div class="container" v-if="showToggle">
                    <div class="d-flex bd-highlight justify-content-center flex-wrap">
                        <router-link v-for="(show,index) in shows" :key="index" to="/bookTicket"
                                     class="links flex-fill">
                            <div @click="setStateValue(show)" class=" border p-2 m-2 text-center"
                                 style="border-radius: 5px;">
                                {{ show }}
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
            <span class="alert alert-danger mx-2 mb-2" v-else>{{ error }}</span>
        </div>
        <loading :loading="isLoading"/>
    </div>
</template>

<script>
import Loading from "./loading";

export default {
    name: "movieDetails",
    data: function () {
        return {
            movie: {
                id: "",
                title: "",
                overview: "",
                release_year: "",
                image_path: "",
            },
            casts: [],
            city: [],
            cities: [],
            theaters: [],
            shows: [],
            city_id: "",
            theater_id: "",
            cityBool: false,
            cityData: false,
            error: "",
            showToggle: false,
            isLoading: false,
        }
    },
    components: {
        Loading
    },
    updated() {
        if (this.shows.length === 0) {
            this.showToggle = false;
        }
    },
    methods: {
        getMovie: async function () {
            this.isLoading = true;
            await axios.get('/movie/' + this.$route.params.id)
                .then(response => {
                    this.movie.id = response.data.id;
                    this.movie.title = response.data.title;
                    this.movie.overview = response.data.overview;
                    this.movie.release_year = response.data.release_year;
                    this.movie.image_path = response.data.image_path;
                    this.getCasts(response.data.id);
                    this.getCities(response.data.id);
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        },
        getCasts: async function (id) {
            await axios.get('/castMovie/' + id)
                .then(response => {
                    this.casts = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getTheaters: async function () {
            this.shows = [];
            this.theater_id = false;
            await axios.get('/theater/getTheater/' + this.city_id)
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
        getCities: async function ($id) {
            this.isLoading = true;
            await axios.get('/city/getCity/' + $id)
                .then(response => {
                    this.cities = response.data
                    if (this.cities.length > 0) {
                        this.cityData = true
                    } else if (this.cities.length === 0) {
                        this.error = "Booking Close"
                    }
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        },
        getShows: async function () {
            await axios.get('/assign/movieShow/' + this.city_id + '/' + this.theater_id + '/' + this.movie.id)
                .then(response => {
                    if (response.data === 0) {
                        this.error = "No Movie Release";
                        this.showToggle = false;
                    } else {
                        this.shows = response.data[0].runtime.split("|");
                        this.error = "";
                        this.showToggle = true;
                    }
                })
                .catch(error => {
                    console.log(error);
                })
        },
        setStateValue: function (show) {
            const thisValue = this;
            const cities = this.cities.filter(function (elem) {
                if (elem.id === thisValue.city_id) return elem;
            });
            const theaters = this.theaters.filter(function (elem) {
                if (elem.id === thisValue.theater_id) return elem;
            });
            const city = cities[0];
            const theater = theaters[0];
            sessionStorage.setItem("city_id", city.id);
            sessionStorage.setItem("city_name", city.city_name);
            sessionStorage.setItem("theater_id", theater.id);
            sessionStorage.setItem("theater_name", theater.theater_name);
            sessionStorage.setItem("movie_id", this.movie.id);
            sessionStorage.setItem("movie_name", this.movie.title);
            sessionStorage.setItem("show", show);
        }
    },
    created() {
        this.getMovie();
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
