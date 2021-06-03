<template>
    <div class="container">
        <div class="card" v-if="!isLoading">
            <div class="card-header">
                <b>{{ cast.name }}</b>
            </div>
            <div class="card-body">
                <p class="card-text">Bio : {{ cast.bio }}</p>
                <p class="card-text">Date of Birth : {{ cast.dob }}</p>
            </div>
            <div class="card-footer">
                <h5 class="card-text">Cast Movies : </h5>
                <div class="container">
                    <div class="d-flex bd-highlight flex-wrap">
                        <div class="card border-dark m-3 flex-fill" v-for="(movie,index) in movies" :key="index">
                            <div class="card-body">
                                <h5 class="card-title">{{ movie.title }}</h5>
                                <p>{{ movie.overview }}</p>
                                <router-link :to="'/user/movie/'+movie.id" class="btn btn-primary">Read More</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <loading :loading="isLoading"/>
    </div>
</template>

<script>
import Loading from "./loading";
export default {
    name: "castDetails",
    data: function () {
        return {
            cast: {
                id: "",
                name: "",
                bio: "",
                dob: "",
            },
            movies:[],
            city: [],
            isLoading: false,
        }
    },
    components:{
        Loading
    },
    methods: {
        getMovie: async function () {
            this.isLoading = true;
            await axios.get('/cast/' + this.$route.params.id)
                .then(response => {
                    this.cast.id = response.data.id;
                    this.cast.name = response.data.name;
                    this.cast.bio = response.data.bio;
                    this.cast.dob = response.data.date_of_birth;
                    this.getCastMovies(response.data.id);
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        },
        getCastMovies:function (id){
            this.isLoading = true;
            axios.get('/castMovie/movie/'+id)
                .then(response=>{
                    this.movies = response.data
                })
                .catch(error=>{
                    console.log(error);
                })
            this.isLoading = false;
        }
    },
    created() {
        this.getMovie();
    }
}
</script>

<style scoped>

</style>
