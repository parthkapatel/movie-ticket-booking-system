<template>
    <div>
        <div v-for="(movie,index) in movies" :key="index">
            <display-movies
                :movie="movie"
                class="movie"
            />
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
