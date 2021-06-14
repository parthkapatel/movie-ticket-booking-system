<template>
    <div class="container">
        <button @click="revert" :class="btnTextColor">{{ btnText }}</button>
        <div :class="alert" class="w-50" role="alert" v-if="error">
            {{ error }}
        </div>
        <form class="mt-3" id="addMovie" enctype="multipart/form-data" @submit="addMovie" v-if="show">
            <div class="form-group">
                <label>Enter Movie Title </label>
                <input v-model="movie_id" type="hidden">
                <input v-model="title" type="text" class="form-control" placeholder="Enter Movie Title">
            </div>
            <div class="form-group">
                <label>Enter Movie Overview</label>
                <textarea v-model="overview" rows="5" cols="10" class="form-control"
                          placeholder="Enter Movie Overview"></textarea>
            </div>
            <div class="form-group">
                <label>Select Release Year</label>
                <input v-model="release_year" type="date" class="form-control" placeholder="Select Release Year">
            </div>
            <div class="form-group">
                <label>Select Movie Image</label>
                <input  type="file" v-on:change="onChange" accept=".jpeg,.jpg" class="form-control" placeholder="Select Movie Image">
            </div>
            <button class="btn btn-primary">{{ MovieButton }}</button>
        </form>
        <list-movies v-if="!isLoading" :movies="movies" @updateMovie="onUpdateMovie"
                     @deleteMovie="onDeleteMovie"></list-movies>
        <loading :loading="isLoading"/>
    </div>
</template>

<script>
import listMovies from "./listMovies";
import Loading from "../loading";

export default {
    name: "movieForm",
    components: {
        listMovies,
        Loading
    },
    data: function () {
        return {
            movie_id: "",
            title: "",
            overview: "",
            release_year: "",
            runtime: [],
            movie_image: "",
            error: "",
            alert: "alert alert-success",
            movies: [],
            show: false,
            btnText: "Add Movie",
            btnTextColor: "btn btn-primary",
            MovieButton: "Add New Movies",
            isLoading: false,
        }
    },
    methods: {
        onChange(e) {
            this.movie_image = e.target.files[0];
        },
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


            if (this.title && this.overview && this.release_year) {

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                e.preventDefault();



                if (this.movie_id === "") {
                    let data = new FormData();
                    data.append('title', this.title);
                    data.append('overview', this.overview);
                    data.append('release_year', this.release_year);
                    data.append('movie_image', this.movie_image);
                    axios.post('/movie/store', data, config)
                        .then(response => {
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
                    let data = new FormData();
                    data.append('title', this.title);
                    data.append('overview', this.overview);
                    data.append('release_year', this.release_year);
                    data.append('movie_image', this.movie_image);
                    axios.post('/movie/' + this.movie_id,  data, config)
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
            axios.delete('/movie/' + Movie.id, Movieid)
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
        },
        getMovies: function () {
            this.isLoading = true;
            axios.get('/movie/get')
                .then(response => {
                    this.movies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        },
    },
    created() {
        this.getMovies();
    }
}
</script>

<style scoped>
.container{
    color: #ADEFD1FF;
}
</style>
