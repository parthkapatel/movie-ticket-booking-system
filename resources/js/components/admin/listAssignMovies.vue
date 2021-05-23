<template>
    <div class="my-3">
        <div class="table-responsive table-striped text-center" >
            <table class="table">
                <thead class="thead-dark">
                <th scope="col">Id</th>
                <th scope="col">City Name</th>
                <th scope="col">Theater Name</th>
                <th scope="col">Movie Title</th>
                <th scope="col">Movie Runtime</th>
                <th scope="col">Created_at</th>
                <th scope="col" colspan="2">Action</th>
                </thead>
                <tbody>
                <tr v-for="(release,index) in releaseMovies" :key="index">
                    <td>{{ ++index }}</td>
                    <td>{{ release.city_name }}</td>
                    <td>{{ release.theater_name }}</td>
                    <td>{{ release.title }}</td>
                    <td>{{ release.runtime }}</td>
                    <td>{{ release.created_at }}</td>
                    <td><button class="btn btn-primary" @click="updateMovie(release)">Edit</button></td>
                    <td><button @click.prevent="deleteMovie(release)" class="btn btn-danger">Delete</button></td>
                </tr>
                <tr v-if="releaseMovies.length == 0">
                    <td colspan="8">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "listAssignMovies",
    props:['releaseMovies'],
    methods:{
        updateMovie:function(release){
            this.$emit('updateMovie', release)
        },
        deleteMovie:function (release){
            this.$emit('deleteMovie', release)
        },
    }
}
</script>

<style scoped>

</style>
