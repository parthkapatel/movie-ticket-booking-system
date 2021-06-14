<template>
    <div class="container grid md:grid-cols-2 lg:grid-cols-3 sm:grid-cols-1 gap-4">
        <div class="" v-for="(movie,index) in movies" :key="index" v-if="movies.length > 0">
            <display-movies
                :movie="movie"
                class="movie"
            />
        </div>
        <div class="text-center" v-if="movies.length === 0">
            <h5 class="m-5 text-light">No Data Found</h5>
        </div>
    </div>
</template>

<script>
import displayMovies from './displayMovies.vue'
export default {
    name: "displayView",
    props:['movies'],
    components:{
        displayMovies,
    },
}
</script>

<style scoped>

</style>
