<template>
    <div class="my-3">
        <div class="table-responsive table-striped text-center" >
            <table class="table">
                <thead class="thead-dark">
                <th scope="col">Id</th>
                <th scope="col">Movie Title</th>
                <th scope="col">Movie Overview</th>
                <th scope="col">Movie Release year</th>
                <th scope="col">Created_at</th>
                <th scope="col" colspan="2">Action</th>
                </thead>
                <tbody>
                <tr v-for="(movie,index) in movies" :key="index">
                    <td>{{ ++index }}</td>
                    <td>{{ movie.title }}</td>
                    <td>{{ movie.overview }}</td>
                    <td>{{ movie.release_year }}</td>
                    <td>{{ movie.created_at }}</td>
                    <td><button class="btn btn-primary" @click="updateMovie(movie)">Edit</button></td>
                    <td><button @click.prevent="deleteMovie(movie)" class="btn btn-danger">Delete</button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "listMovies",
    props:['movies'],
    data:function (){
        return{
            show:false,
        }
    },
    methods:{
        updateMovie:function(movie){
            this.$emit('updateMovie', movie)
        },
        deleteMovie:function (movie){
            this.$emit('deleteMovie', movie)
        },
    }
}
</script>

<style scoped>

</style>
