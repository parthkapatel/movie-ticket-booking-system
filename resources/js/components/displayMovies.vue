<template>
    <div class="m-2">
        <div class="card">
            <img class="card-img-top" style="width:auto;height:450px;" :src="movie.image_path" :alt="movie.title">
            <div class="card-body">
                <h5 class="card-title">Title : <b>{{ movie.title }}</b></h5>
            </div>
            <div class="card-footer ">
                <router-link :to="'/user/movie/'+movie.id" class="float-right card-link btn btn-primary m-0 p-2">Book Tickets</router-link>
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
