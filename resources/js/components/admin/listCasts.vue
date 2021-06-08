<template>
    <div class="my-3">
        <div class="table-responsive table-striped text-center" >
            <table class="table">
                <thead class="thead-dark">
                <th scope="col">Id</th>
                <th scope="col">Cast Name</th>
                <th scope="col">Cast Bio</th>
                <th scope="col">Cast BOD</th>
                <th scope="col">Cast Image</th>
                <th scope="col">Created_at</th>
                <th scope="col" colspan="2">Action</th>
                </thead>
                <tbody>
                <tr v-if="casts.length > 0" v-for="(cast,index) in casts" :key="index">
                    <td>{{ ++index }}</td>
                    <td>{{ cast.name }}</td>
                    <td>{{ cast.bio }}</td>
                    <td>{{ cast.date_of_birth }}</td>
                    <td><img class="border rounded" :src="cast.image_path" width="100px" height="100px"></td>
                    <td>{{ cast.created_at }}</td>
                    <td><button class="btn btn-primary" @click="updateCast(cast)">Edit</button></td>
                    <td><button @click.prevent="deleteCast(cast)" class="btn btn-danger">Delete</button></td>
                </tr>
                <tr v-if="casts.length == 0">
                    <td colspan="7">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "listCasts",
    props:['casts'],
    data:function (){
        return{
            show:false,
        }
    },
    methods:{
        updateCast:function(cast){
            this.$emit('updateCast', cast)
        },
        deleteCast:function (cast){
            this.$emit('deleteCast', cast)
        },
    }
}
</script>

<style scoped>

</style>
