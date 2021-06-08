<template>
    <div>
        <div v-for="(movie,index) in movies" :key="index" v-if="movies.length > 0">
            <display-movies
                :movie="movie"
                class="movie"
            />
        </div>
        <div class="text-center" v-if="movies.length === 0">
            <h5 class="m-5">No Data Found</h5>
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
