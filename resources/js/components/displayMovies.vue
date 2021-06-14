<template>
    <div class="my-2 max-w-lg  bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="container p-0 m-0">
            <div class="md:flex-shrink-0">
                <img class="h-48 w-full object-cover md:h-100 md:w-100" :src="movie.image_path" :alt="movie.title">
            </div>
            <div class="p-2 flex">
                <div class="flex-auto uppercase tracking-wide text-lg text-indigo-500 font-semibold ">{{ movie.title }}</div>
                <router-link :to="'/user/movie/'+movie.id"
                             class="card-link  font-semibold rounded-lg shadow-md text-white bg-green-500 hover:bg-green-700 m-2 p-2">
                    Book
                </router-link>
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
