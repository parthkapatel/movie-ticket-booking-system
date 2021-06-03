<template>
    <div class="container">
        <div>
            <div class="text-right m-2">
                <input type="text" v-model="str" @keyup="searchMovie" class="form-control"
                       placeholder="Search here..(city,theater,title)">
            </div>
            <loading :loading="isLoading"/>
            <display-view :movies="movies" v-if="!isLoading"/>
        </div>
    </div>
</template>

<script>
import displayView from "./displayView";
import Loading from "./loading";

export default {
    name: "home",
    components: {
        displayView,
        Loading
    },
    data: function () {
        return {
            movies: [],
            str: "",
            isLoading: false,
        }
    },
    methods: {
        getReleaseMovies: async function () {
            this.isLoading = true;
            await axios.get('/assign/getMoviesForHome')
                .then(response => {
                    this.movies = response.data;
                    if (response.data.length === 0 || response.data.length > 0) {
                        this.isLoading = false;
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        searchMovie: async function() {
            this.isLoading = true;
            if (this.str === "") {
                 await this.getReleaseMovies();
            } else {
                await axios.get('/search/' + this.str)
                    .then(response => {
                        this.movies = response.data
                    })
                    .catch(error => {
                        console.log(error);
                    });
                if (this.movies.length === 0 || this.movies.length > 0) {
                    this.isLoading = false;
                }
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
