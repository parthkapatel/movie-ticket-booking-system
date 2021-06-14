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
                    <tr v-if="cities.length > 0" v-for="(city,index) in cities" :key="index">
                        <td>{{ ++index }}</td>
                        <td>{{ city.city_name }}</td>
                        <td>{{ city.created_at }}</td>
                        <td><button class="btn btn-primary" @click="updateCity(city)">Edit</button></td>
                        <td><button @click.prevent="deleteCity(city)" class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr v-if="cities.length == 0">
                        <td colspan="5">No Data Found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "listCities",
    props:['cities'],
    methods:{
        updateCity:function(city){
            this.$emit('updateCity', city)
        },
        deleteCity:function (city){
            this.$emit('deleteCity', city)
        }
    }
}
</script>

<style scoped>
.table{
    color: #ADEFD1FF;
}
</style>
