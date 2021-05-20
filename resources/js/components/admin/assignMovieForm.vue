<template>
    <div class="container">
        <button @click="revert" :class="btnTextColor">{{ btnText }}</button>
        <div :class="alert" class="w-50" role="alert" v-if="error">
            {{ error }}
        </div>
        <form class="mt-3" id="addMovie" @submit="addMovie" v-if="show">
            <div class="form-group">
                <label>Select City</label>
                <select v-model="city_id" class="form-control">
                    <option v-for="(city,index) in cities" :key="index" :value="city.id">{{ city.city_name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Theater</label>
                <select v-model="theater_id" class="form-control">
                    <option v-for="(theater,index) in theaters" :key="index" :value="theater.id">{{
                            theater.theater_name
                        }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Movie</label>
                <select v-model="movie_id" class="form-control">
                    <option v-for="(movie,index) in movies" :key="index" :value="movie.id">{{ movie.title }}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Time Slots</label>
                <select v-model="runtime"  multiple class="form-control" >
                    <option v-for="(slot,index) in slots" :key="index" :value="slot">{{ slot }}</option>
                </select>
            </div>
            <button class="btn btn-primary">{{ MovieButton }}</button>
        </form>
        <list-assign-movies v-if="!show" :releaseMovies="releaseMovies" @updateMovie="onUpdateMovie"
                     @deleteMovie="onDeleteMovie"></list-assign-movies>
    </div>
</template>

<script>
import listAssignMovies from "./listAssignMovies";
export default {
    name: "assignTheaterForm",
    components:{
      listAssignMovies
    },
    data: function () {
        return {
            release_id:"",
            city_id: "",
            theater_id: "",
            movie_id: "",
            error: "",
            alert: "alert alert-success",
            movies: [],
            cities: [],
            theaters: [],
            runtime:[],
            releaseMovies:[],
            slots:[
                "12:00","3:00","6:00","9:00"
            ],
            show: false,
            btnText: "Add Movie",
            btnTextColor: "btn btn-primary",
            MovieButton: "Add New Movies",
        }
    },
    methods: {
        changeMovieButton: function () {
            this.MovieButton = "Update Movies";
            if (this.movie_id === "") {
                this.MovieButton = "Add New Movies";
            }
        },
        revert: function () {
            if (this.show === false) {
                this.btnText = "Close";
                this.btnTextColor = "btn btn-danger";
            } else {
                this.movie_id = "";
                this.title = "";
                this.overview = "";
                this.release_year = "";
                this.btnText = "Add Movie";
                this.btnTextColor = "btn btn-primary";
            }
            this.changeMovieButton();
            this.show = !this.show;
        },
        addMovie: function (e) {
            if (this.city_id && this.theater_id && this.movie_id && this.runtime) {
                if (this.release_id === "") {
                    const movies = {
                        city_id: this.city_id,
                        theater_id: this.theater_id,
                        movie_id: this.movie_id,
                        runtime:this.runtime,
                    };
                    axios.post('/api/assign/store', movies)
                        .then(response => {
                            this.alert = "alert alert-success";
                            this.error = "Movie Added Successfully";
                            this.revert();
                            this.getCities();
                            this.getMovies();
                            this.getTheaters();
                            this.getReleaseMovies();
                            this.city_id = 0;
                            this.theater_id = 0;
                            this.movie_id = 0;
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                } else {
                    const movies = {
                        city_id: this.city_id,
                        theater_id: this.theater_id,
                        movie_id: this.movie_id,
                        runtime:this.runtime,
                    };
                    axios.put('/api/assign/' + this.release_id, movies)
                        .then(response => {
                            this.alert = "alert alert-success";
                            this.error = "Movie Update Successfully";
                            this.getCities();
                            this.getMovies();
                            this.getTheaters();
                            this.getReleaseMovies();
                            this.changeMovieButton();
                            this.revert();
                            this.city_id = 0;
                            this.theater_id = 0;
                            this.movie_id = 0;
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        this.release_id = "";
                        setTimeout(() => this.error = "", 1000)
                    });
                }
            }

            if (this.city_id === "") {
                this.alert = "alert alert-danger"
                this.error = "Select City!"
            } else if (this.theater_id === "") {
                this.alert = "alert alert-danger"
                this.error = "Select Theater!"
            } else if (this.release_year === "") {
                this.alert = "alert alert-danger"
                this.error = "Select Movie!"
            } else if (this.runtime === "") {
                this.alert = "alert alert-danger"
                this.error = "Select Time Slot!"
            }
            e.preventDefault();

        },
        onUpdateMovie: function (release) {
            this.release_id = release.id;
            this.city_id = release.city_id;
            this.theater_id = release.theater_id;
            this.movie_id = release.movie_id;
            this.changeMovieButton();
            this.revert();
        },
        onDeleteMovie: function (movie) {
            const movieid = {id: movie.id};
            axios.delete('/api/movie/' + movie.id, movieid)
                .then(response => {
                    this.alert = "alert alert-success";
                    this.error = "Movie Deleted Successfully";
                    this.getCities();
                    this.getMovies();
                    this.getTheaters();
                    this.getReleaseMovies();
                })
                .catch(error => {
                    console.log(error);
                }).finally(() => {
                setTimeout(() => this.error = "", 1000)
            });
        },getReleaseMovies: function () {
            axios.get('/api/assign/get')
                .then(response => {
                    this.releaseMovies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getMovies: function () {
            axios.get('/api/movie/get')
                .then(response => {
                    this.movies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        }, getCities: function () {
            axios.get('/api/city/get')
                .then(response => {
                    this.cities = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        }, getTheaters: function () {
            axios.get('/api/theater/get')
                .then(response => {
                    this.theaters = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },
    created() {
        this.getCities();
        this.getMovies();
        this.getTheaters();
        this.getReleaseMovies();
    }
}
</script>

<style scoped>

</style>
