<template>
    <div class="container">
        <div :class="alert" class="w-50" role="alert" v-if="error">
            {{ error }}
        </div>
        <form id="addcity" @submit="addCity">
            <div class="form-group">
                <label>Enter City Name</label>
                <input v-model="city_id" type="hidden">
                <input v-model="city_name" class="form-control" placeholder="Enter City Name">
            </div>
            <button class="btn btn-primary">Add New City</button>
        </form>
        <listCities :cities="cities" @updateCity="onUpdateCity" @deleteCity="onDeleteCity"></listCities>
    </div>
</template>

<script>
import listCities from "./listCities";
export default {
    name: "newCityForm",
    components:{
      listCities
    },
    data: function () {
        return {
            city_id:"",
            city_name: "",
            error: "",
            alert: "alert alert-success",
            cities: [],
        }
    },
    methods: {
        addCity: function (e) {
            if (this.city_name) {
                if(this.city_id === ""){
                    const city = {city_name: this.city_name};
                    axios.post('/api/city/store', city)
                        .then(response => {
                            this.city_name = "";
                            this.error = "City Added Successfully";
                            this.getCities();
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                }else{
                    const city = {city_name: this.city_name,id:this.city_id};
                    axios.put('/api/city/'+this.city_id, city)
                        .then(response => {
                            this.city_name = "";
                            this.error = "City Update Successfully";
                            this.getCities();
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                }
            } else {
                this.alert = "alert alert-danger"
                this.error = "City name is required!"
            }
            e.preventDefault();

        },
        getCities: function () {
            axios.get('/api/city/get')
                .then(response => {
                    this.cities = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        onUpdateCity:function (city){
            this.city_id = city.id;
            this.city_name = city.city_name;
        },
        onDeleteCity:function (city){
            const cityid = {id:city.id};
            axios.delete('/api/city/'+city.id, cityid)
                .then(response => {
                    this.city_name = "";
                    this.error = "City Deleted Successfully";
                    this.getCities();
                })
                .catch(error => {
                    console.log(error);
                }).finally(() => {
                setTimeout(() => this.error = "", 1000)
            });
        }
    },
    created() {
        this.getCities();
    }

}
</script>

<style scoped>

</style>
