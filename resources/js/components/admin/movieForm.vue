<template>
    <div class="container">
        <button @click="revert" :class="btnTextColor">{{ btnText }}</button>
        <div :class="alert" class="w-50" role="alert" v-if="error">
            {{ error }}
        </div>
        <form class="mt-3" id="addMovie" @submit="addMovie" v-if="show">
            <div class="form-group">
                <label>Enter Movie Title </label>
                <input v-model="movie_id" type="hidden">
                <input v-model="title" type="text" class="form-control" placeholder="Enter Movie Title">
            </div>
            <div class="form-group">
                <label>Enter Movie Overview</label>
                <textarea v-model="overview" rows="5" cols="10" class="form-control" placeholder="Enter Movie Overview"></textarea>
            </div>
            <div class="form-group">
                <label>Select Release Year</label>
                <input v-model="release_year" type="date" class="form-control" placeholder="Select Release Year">
            </div>
            <button class="btn btn-primary">{{ MovieButton }}</button>
        </form>
        <list-movies v-if="!show" :movies="movies" @updateMovie="onUpdateMovie" @deleteMovie="onDeleteMovie"></list-movies>
    </div>
</template>

<script>
import listMovies from "./listMovies";
export default {
    name: "movieForm",
    components: {
        listMovies
    },
    data: function () {
        return {
            movie_id: "",
            title: "",
            overview:"",
            release_year:"",
            runtime:[],
            error: "",
            alert: "alert alert-success",
            movies: [],
            casts:[],
            show: false,
            btnText: "Add Movie",
            btnTextColor: "btn btn-primary",
            MovieButton:"Add New Movies",
        }
    },
    methods: {
        changeMovieButton:function (){
            this.MovieButton = "Update Movies";
            if(this.movie_id === ""){
                this.MovieButton = "Add New Movies";
            }
        },
        revert: function () {
            if(this.show === false){
                this.btnText = "Close";
                this.btnTextColor = "btn btn-danger";
            }else{
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
            if (this.title && this.overview && this.release_year ) {
                if (this.movie_id === "") {
                    const movies = {
                        title: this.title,
                        overview:this.overview,
                        release_year:this.release_year,
                    };
                    axios.post('/api/movie/store', movies)
                        .then(response => {
                            console.log(response);
                            this.movie_id = "";
                            this.title = "";
                            this.overview = "";
                            this.release_year = "";
                            this.alert = "alert alert-success";
                            this.error = "Movie Added Successfully";
                            this.revert();
                            this.getMovies();
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                } else {
                    const Movie = {
                        title: this.title,
                        overview:this.overview,
                        release_year:this.release_year,
                    };
                    axios.put('/api/movie/' + this.movie_id, Movie)
                        .then(response => {
                            this.movie_id = "";
                            this.title = "";
                            this.overview = "";
                            this.release_year = "";
                            this.alert = "alert alert-success";
                            this.error = "Movie Update Successfully";
                            this.getMovies();
                            this.changeMovieButton();
                            this.revert();
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                }
            }
            if (this.title === "") {
                this.alert = "alert alert-danger"
                this.error = "Movie title is required!"
            } else if (this.overview === "") {
                this.alert = "alert alert-danger"
                this.error = "Movie Overview is required!"
            } else if (this.release_year === "") {
                this.alert = "alert alert-danger"
                this.error = "Movie Release Year is required!"
            }
            e.preventDefault();

        },
        onUpdateMovie: function (Movie) {
            this.movie_id = Movie.id;
            this.title = Movie.title;
            this.overview = Movie.overview;
            this.release_year = Movie.release_year;
            this.changeMovieButton();
            this.revert();
        },
        onDeleteMovie: function (Movie) {
            const Movieid = {id: Movie.id};
            axios.delete('/api/movie/' + Movie.id, Movieid)
                .then(response => {
                    this.alert = "alert alert-success";
                    this.error = "Movie Deleted Successfully";
                    this.getMovies();
                })
                .catch(error => {
                    console.log(error);
                }).finally(() => {
                setTimeout(() => this.error = "", 1000)
            });
        }, getMovies: function () {
            axios.get('/api/movie/get')
                .then(response => {
                    this.movies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },getCasts: function () {
            axios.get('/api/cast/get')
                .then(response => {
                    this.casts = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },
    created() {
        this.getCasts();
        this.getMovies();
    }
}
</script>

<style scoped>

</style>
