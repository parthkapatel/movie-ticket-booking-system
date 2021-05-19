<template>
    <div class="my-3">
        <div class="table-responsive table-striped text-center">
            <table class="table">
                <thead class="thead-dark">
                    <th scope="col">Id</th>
                    <th scope="col">City Name</th>
                    <th scope="col">Created_at</th>
                    <th scope="col" colspan="2">Action</th>
                </thead>
                <tbody>
                    <tr v-for="(theater,index) in theaters" :key="index">
                        <td>{{ ++index }}</td>
                        <td>{{ theater.theater_name }}</td>
                        <td>{{ theater.created_at }}</td>
                        <td><button class="btn btn-primary" @click="updateTheater(theater)">Edit</button></td>
                        <td><button @click.prevent="deleteTheater(theater)" class="btn btn-danger">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "listTheaters",
    props:['theaters'],
    methods:{
        updateTheater:function(theater){
            this.$emit('updateTheater', theater)
        },
        deleteTheater:function (theater){
            this.$emit('deleteTheater', theater)
        }
    }
}
</script>

<style scoped>

</style>
