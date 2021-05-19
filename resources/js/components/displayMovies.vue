<template>
    <div class="flex-fill m-2">
        <div class="card" style="width: 15rem;">
            <div class="card-body">
                <h5 class="card-title">Title : <b>{{ movie.title }}</b></h5>
                <p class="card-text">Overview: {{ movie.overview }}</p>
                <p class="card-text">Release Year: {{ movie.release_year }}</p>
            </div>
            <div class="card-footer">
<!--                <router-link :to="'/user/movie/'+movie.id" class="card-link">Read More</router-link>-->
                <router-link :to="'/user/movie/'+movie.id" class="card-link btn btn-primary m-0 p-2">Book Tickets</router-link>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "displayMovies",
    props: ["movie"],
}
</script>

<style scoped>

</style>
