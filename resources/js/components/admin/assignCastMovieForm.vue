<template>
    <div class="container">
        <button @click="(show = !show) ? release_id= '' :''" class="btn btn-primary" v-if="!show">Add New Cast</button>
        <button @click="show = !show" class="btn btn-danger" v-if="show">Close</button>
        <div :class="alert" role="alert" v-if="error">
            {{ error }}
        </div>
        <form class="mt-3" id="addCastMovie" @submit="addCastMovie" v-if="show">
            <div class="form-group ">
                <label>Select Cast</label>
                <select v-model="cast_id" class="form-control">
                    <option v-for="(cast,index) in casts" :key="index" :value="cast.id">{{ cast.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Select Movie</label>
                <select v-model="movie_id" class="form-control">
                    <option v-for="(movie,index) in movies" :key="index" :value="movie.id">{{ movie.title }}</option>
                </select>
            </div>
            <button class="btn btn-primary">{{ (release_id === "" ? 'Assign New Cast' : 'Update Cast') }}</button>
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
        }
    },
    methods: {
        addCastMovie: function (e) {
            if (this.cast_id  && this.movie_id) {
                if (this.release_id === "") {
                    const movies = {
                        cast_id: this.cast_id,
                        movie_id: this.movie_id,
                    };
                    axios.post('/castMovie/store', movies)
                        .then(response => {
                            if(response.data.status === "error"){
                                this.alert = "alert alert-danger";
                                this.error = response.data.message;
                            }else if(response.data.status === "success"){
                                this.alert = "alert alert-success";
                                this.error = response.data.message;
                                this.getCasts();
                                this.getMovies();
                                this.getCastMovies();
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 2000);
                        this.release_id="";
                        this.cast_id = 0;
                        this.movie_id = 0;
                    });
                } else {
                    const movies = {
                        cast_id: this.cast_id,
                        movie_id: this.movie_id,
                    };
                    axios.put('/castMovie/' + this.release_id, movies)
                        .then(response => {
                            if(response.data.status === "error"){
                                this.alert = "alert alert-danger";
                                this.error = response.data.message;
                            }else if(response.data.status === "success"){
                                this.alert = "alert alert-success";
                                this.error = response.data.message;
                                this.getCasts();
                                this.getMovies();
                                this.getCastMovies();
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        this.release_id = "";
                        setTimeout(() => this.error = "", 2000);
                        this.cast_id = 0;
                        this.movie_id = 0;
                        this.release_id="";
                        this.show = !this.show;
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
            this.show = !this.show;
            this.release_id = release.id;
            this.cast_id = release.cast_id;
            this.movie_id = release.movie_id;
        },
        onDeleteMovie: function (movie) {
            const movieid = {id: movie.id};
            axios.delete('/castMovie/' + movie.id, movieid)
                .then(response => {
                    this.release_id="";
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
                setTimeout(() => this.error = "", 2000)
            });
        },
        getMovies: function () {
            axios.get('/movie/get')
                .then(response => {
                    this.movies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        }, getCasts: function () {
            axios.get('/cast/get')
                .then(response => {
                    this.casts = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getCastMovies: function () {
            axios.get('/castMovie/get')
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
