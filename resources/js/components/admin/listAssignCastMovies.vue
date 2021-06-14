<template>
    <div class="my-3">
        <div class="table-responsive table-striped text-center" >
            <table class="table">
                <thead class="thead-dark">
                <th scope="col">Id</th>
                <th scope="col">Cast Name</th>
                <th scope="col">Movie Name</th>
                <th scope="col">Created_at</th>
                <th scope="col" colspan="2">Action</th>
                </thead>
                <tbody>
                <tr v-if="castMovies.length > 0" v-for="(movie,index) in castMovies" :key="index">
                    <td>{{ ++index }}</td>
                    <td>{{ movie.name }}</td>
                    <td>{{ movie.title }}</td>
                    <td>{{ movie.created_at }}</td>
                    <td><button class="btn btn-primary" @click="updateCastMovie(movie)">Edit</button></td>
                    <td><button @click.prevent="deleteCastMovie(movie)" class="btn btn-danger">Delete</button></td>
                </tr>
                <tr v-if="castMovies.length == 0">
                    <td colspan="6">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "listAssignCastMovies",
    props:['castMovies'],
    data:function (){
        return{
            show:false,
        }
    },
    methods:{
        updateCastMovie:function(movie){
            this.$emit('updateMovie', movie)
        },
        deleteCastMovie:function (movie){
            this.$emit('deleteMovie', movie)
        },
    }
}
</script>

<style scoped>
.table{
    color: #ADEFD1FF;
}
</style>
