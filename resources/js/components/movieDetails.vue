<template>
    <div class="container">
        <div v-if="!isLoading">
            <div class="card" style="border-radius: 10px;background-color: #00203FFF;color: #ADEFD1FF;">
                <div class="card-header h2">
                    Movie Details
                </div>
                <div class="md:flex">
                    <div class="md:flex-shrink-0">
                        <img class="h-100 w-full object-cover md:h-full md:w-48" :src="movie.image_path" :alt="movie.title">
                    </div>
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-lg text-indigo-500 font-semibold">{{ movie.title }}</div>
                        <p class="mt-2 text-gray-500">{{ movie.overview }}</p>
                    </div>
                </div>
                <div class="card-footer" v-if="cityData">
                    <div class="container p-3">
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
                                         style="border-radius: 5px;background-color: #ADEFD1FF;color: #00203FFF;">
                                        {{ show }}
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container my-3 p-3 text-dark " style="border-radius: 10px;background-color: #b3c1ca;">
                <h5 class=""><b>Cast Member :</b></h5>
                <div class="container p-1 no-scrollbar"
                     style="width:100%;height:auto;overflow-x:auto;white-space: nowrap;overflow-y:hidden;">
                    <div style="display: inline-block;"
                         class="text-center m-1 p-2"
                         v-for="(cast,index) in casts"
                         :key="index">
                        <div class="py-8 px-8 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-2 sm:py-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6">
                            <img class="block mx-auto h-24 rounded-full sm:mx-0 sm:flex-shrink-0" :src="cast.image_path" :alt="cast.name">
                            <div class="text-center space-y-2 sm:text-left">
                                <div class="space-y-0.5">
                                    <p class="text-lg text-black font-semibold">
                                        {{ cast.name }}
                                    </p>
                                </div>
                                <router-link :to="'/user/cast/'+cast.id" style="text-decoration: none;" class="px-4 py-1 text-sm text-purple-600 font-semibold rounded-full border border-purple-200 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">Profile</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container p-4 rounded" style="background-color: #00203FFF;color: #ADEFD1FF;">
                <div :class="status === 'success' ? 'alert alert-success' : 'alert alert-danger'" id="msg" v-if="msg">{{ msg }}</div>
                <form class="form">
                    <div class="form-group">
                        <label for="movie_review">Movie Review</label>
                        <textarea style="resize: none;" v-model="review" name="movie_review" class="form-control"
                                  id="movie_review" cols="30" rows="10"
                                  placeholder="Write your review about the movie"></textarea>
                    </div>
                    <input type="button" class="btn btn-primary" @click="addReview" value="Post Review">
                </form>
                <list-movie-reviews :movieReviews="movieReviews"/>
            </div>
        </div>


        <loading :loading="isLoading"/>
    </div>
</template>

<script>
import Loading from "./loading";
import listMovieReviews from "./listMovieReviews";
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
            movieReviews:[],
            shows: [],
            city_id: "",
            theater_id: "",
            cityBool: false,
            cityData: false,
            error: "",
            showToggle: false,
            isLoading: false,
            review: "",
            msg:"",
            status:"",
        }
    },
    components: {
        Loading,
        listMovieReviews
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
        },
        addReview: function () {
            const data = {
                movieId:this.movie.id,
                review: this.review,
            }
            axios.post('/review/postReview/', data)
                .then(response => {
                    console.log(response);
                    if(response.data.status === "success"){
                        this.status = response.data.status;
                        this.msg = response.data.message;
                    }
                    this.getMovieReview();
                })
                .catch(error => {
                    console.log(error);
                })
            $("#movie_review").html("");
            this.review = "";
            setTimeout(function () {
                $("#msg").hide();
            },2000);
        },
        getMovieReview: async function () {
            this.isLoading = true;
            await axios.get('/review/getAllReviewByMovieId/' + this.$route.params.id)
                .then(response => {
                   this.movieReviews = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        }
    },
    created() {
        this.getMovie();
        this.getTheaters();
        this.getMovieReview();
    }
}
</script>

<style scoped>
.links {
    color: black;
    text-decoration: none;
}
.no-scrollbar::-webkit-scrollbar{
    height: 8px;
}
.no-scrollbar::-webkit-scrollbar-track {
    box-shadow: inset 0 0 3px #101820ff;
    border-radius: 10px;
}
.no-scrollbar::-webkit-scrollbar-thumb {
    background: rgb(0, 32, 63);
    border-radius: 10px;
}

</style>
