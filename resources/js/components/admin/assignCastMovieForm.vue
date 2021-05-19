<template>
    <div class="container">
        <button @click="revert" :class="btnTextColor">{{ btnText }}</button>
        <div :class="alert" class="w-50" role="alert" v-if="error">
            {{ error }}
        </div>
        <form class="mt-3" id="addCastMovie" @submit="addCastMovie" v-if="show">
            <div class="form-group w-50">
                <label>Select Cast</label>
                <select v-model="cast_id" class="form-control">
                    <option v-for="(cast,index) in casts" :key="index" :value="cast.id">{{ cast.name }}</option>
                </select>
            </div>
            <div class="form-group w-50">
                <label>Select Movie</label>
                <select v-model="movie_id" class="form-control">
                    <option v-for="(movie,index) in movies" :key="index" :value="movie.id">{{ movie.title }}</option>
                </select>
            </div>
            <button class="btn btn-primary">{{ MovieButton }}</button>
        </form>
        <list-assign-cast-movies v-if="!show" :castMovies="castMovies" @updateMovie="onUpdateMovie"
                            @deleteMovie="onDeleteMovie"></list-assign-cast-movies>
    </div>
</template>

<script>
import listAssignCastMovies from "./listAssignCastMovies";
export default {
    name: "assignCastMovieForm",
    components:{
        listAssignCastMovies
    },
    data: function () {
        return {
            release_id:"",
            cast_id: "",
            movie_id: "",
            error: "",
            alert: "alert alert-success",
            movies: [],
            casts: [],
            castMovies:[],
            slots:[
                "12:00","3:00","6:00","9:00"
            ],
            show: false,
            btnText: "Add Cast Movie",
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
                this.btnText = "Add Cast Movie";
                this.btnTextColor = "btn btn-primary";
            }
            this.changeMovieButton();
            this.show = !this.show;
        },
        addCastMovie: function (e) {
            if (this.cast_id  && this.movie_id) {
                if (this.release_id === "") {
                    const movies = {
                        cast_id: this.cast_id,
                        movie_id: this.movie_id,
                    };
                    axios.post('/api/castMovie/store', movies)
                        .then(response => {
                            this.alert = "alert alert-success";
                            this.error = "Cast Movie Added Successfully";
                            this.revert();
                            this.getCasts();
                            this.getMovies();
                            this.getCastMovies();
                            this.cast_id = 0;
                            this.movie_id = 0;
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                } else {
                    const movies = {
                        cast_id: this.cast_id,
                        movie_id: this.movie_id,
                    };
                    console.log(this.release_id);
                    axios.put('/api/castMovie/' + this.release_id, movies)
                        .then(response => {
                            this.alert = "alert alert-success";
                            this.error = "Movie Update Successfully";
                            this.getCasts();
                            this.getMovies();
                            this.getCastMovies();
                            this.changeMovieButton();
                            this.revert();
                            this.cast_id = 0;
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

            if (this.cast_id === "") {
                this.alert = "alert alert-danger"
                this.error = "Select City!"
            }  else if (this.movie_id === "") {
                this.alert = "alert alert-danger"
                this.error = "Select Movie!"
            }
            e.preventDefault();

        },
        onUpdateMovie: function (release) {
            this.release_id = release.id;
            this.cast_id = release.cast_id;
            this.movie_id = release.movie_id;
            this.changeMovieButton();
            this.revert();
        },
        onDeleteMovie: function (movie) {
            const movieid = {id: movie.id};
            axios.delete('/api/castMovie/' + movie.id, movieid)
                .then(response => {
                    this.alert = "alert alert-success";
                    this.error = "Movie Deleted Successfully";
                    this.getCasts();
                    this.getMovies();
                    this.getCastMovies();
                    this.getReleaseMovies();
                })
                .catch(error => {
                    console.log(error);
                }).finally(() => {
                setTimeout(() => this.error = "", 1000)
            });
        },
        getMovies: function () {
            axios.get('/api/movie/get')
                .then(response => {
                    this.movies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        }, getCasts: function () {
            axios.get('/api/cast/get')
                .then(response => {
                    this.casts = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getCastMovies: function () {
            axios.get('/api/castMovie/get')
                .then(response => {
                    this.castMovies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },
    created() {
        this.getCasts();
        this.getMovies();
        this.getCastMovies();
    }
}
</script>

<style scoped>

</style>
