<template>
    <div class="container">
        <div>
            <div class="text-right m-2">
                <input type="text" v-model="str" @keyup="searchMovie" class="form-control"
                       placeholder="Search here..(city,theater,title)">
            </div>
            <display-view :movies="movies"/>
        </div>
    </div>
</template>

<script>
import displayView from "./displayView";

export default {
    name: "home",
    components: {
        displayView,
    },
    data: function () {
        return {
            movies: [],
            str: "",
        }
    },
    methods: {
        getReleaseMovies: function () {
            axios.get('/assign/getMoviesForHome')
                .then(response => {
                    this.movies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        searchMovie: function () {
            if (this.str === "") {
                this.getReleaseMovies();
            } else {
                axios.get('/search/' + this.str)
                    .then(response => {
                        this.movies = response.data
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    },
    created() {
        this.getReleaseMovies();
    }
}
</script>

<style scoped>

</style>
