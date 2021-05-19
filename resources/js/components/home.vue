<template>
    <div class="container">
        <div class="text-right m-2">
            <input type="text" v-model="str" @keyup="searchMovie" class="form-control w-50" placeholder="Search here..(city,theater,title)">
        </div>
        <display-view :movies="movies" />
    </div>
</template>

<script>
import displayView from "./displayView";
export default {
    name: "home",
    components: {
        displayView
    },
    data:function (){
        return{
            movies:[],
            str:"",
        }
    },
    methods:{
        getAllMovies:function (){
            axios.get('/api/movie/get')
                .then(response=>{
                    this.movies = response.data
                })
                .catch(error=>{
                    console.log(error);
                })
        },
        searchMovie:function (){
            if(this.str === ""){
                this.getAllMovies();
            }else{
                axios.get('/api/search/'+this.str)
                    .then(response=>{
                        this.movies = response.data
                    })
                    .catch(error=>{
                        console.log(error);
                    })
            }
        }
    },
    created() {
        this.getAllMovies();
    }
}
</script>

<style scoped>

</style>
