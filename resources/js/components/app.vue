<template>
    <div>
        <display-view :movies="movies" />
    </div>
</template>

<script>
import displayView  from "./displayView";
export default {
    name:"app",
    components: {
        displayView
    },
    data:function (){
        return{
            movies:[],
        }
    },
    methods:{
        getMovies(){
            axios.get('/api/getMovies')
            .then(response=>{
                this.movies = response.data
            })
            .catch(error=>{
                console.log(error);
            })
        }
    },
    created() {
        this.getMovies();
    }
}
</script>

<style scoped>

</style>
