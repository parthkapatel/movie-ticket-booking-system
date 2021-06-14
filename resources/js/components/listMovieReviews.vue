<template>
    <div class="my-4">
        <div class="p-6 m-2 max-w-lg bg-white rounded-xl flex items-center space-x-4" v-for="(movieReview,index) in movieReviews" :key="index">
            <div>
                <div class="text-xl font-medium text-black h4">{{ movieReview.name }}</div>
                <p class="text-gray-500 lead break-all">{{ movieReview.review }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "listMovieReviews",
    props:['movieReviews'],
    computed: {
        ...mapGetters([
            'userId',
        ])
    },
}
</script>

<style scoped>

</style>
