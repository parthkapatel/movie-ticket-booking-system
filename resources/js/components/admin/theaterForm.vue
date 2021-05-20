<template>
    <div class="container">
        <div :class="alert" class="w-50" role="alert" v-if="error">
            {{ error }}
        </div>
        <form id="addTheater" @submit="addTheater">
            <div class="form-group">
                <label>Enter Theater Name</label>
                <input v-model="theater_id" type="hidden">
                <input v-model="theater_name" class="form-control" placeholder="Enter Theater Name">
            </div>
            <button class="btn btn-primary">Add New Theater</button>
        </form>
        <list-theaters :theaters="theaters" @updateTheater="onUpdateTheater" @deleteTheater="onDeleteTheater"></list-theaters>
    </div>
</template>

<script>
import listTheaters from "./listTheaters";
export default {
    name: "theaterForm",
    components:{
        listTheaters
    },
    data: function () {
        return {
            theater_id:"",
            theater_name: "",
            error: "",
            alert: "alert alert-success",
            theaters: [],
        }
    },
    methods: {
        addTheater: function (e) {
            if (this.theater_name) {
                if(this.theater_id === ""){
                    const theater = {theater_name: this.theater_name};
                    axios.post('/api/theater/store', theater)
                        .then(response => {
                            this.theater_name = "";
                            this.error = "Theater Added Successfully";
                            this.getTheaters();
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                }else{
                    const theater = {theater_name: this.theater_name,id:this.theater_id};
                    axios.put('/api/theater/'+this.theater_id, theater)
                        .then(response => {
                            this.theater_name = "";
                            this.error = "Theater Update Successfully";
                            this.getTheaters();
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                }
            } else {
                this.alert = "alert alert-danger"
                this.error = "Theater name is required!"
            }
            e.preventDefault();

        },
        getTheaters: function () {
            axios.get('/api/theater/get')
                .then(response => {
                    this.theaters = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        onUpdateTheater:function (theater){
            this.theater_id = theater.id;
            this.theater_name = theater.theater_name;
        },
        onDeleteTheater:function (theater){
            const theaterid = {id:theater.id};
            axios.delete('/api/theater/'+theater.id, theaterid)
                .then(response => {
                    this.theater_name = "";
                    this.error = "Theater Deleted Successfully";
                    this.getTheaters();
                })
                .catch(error => {
                    console.log(error);
                }).finally(() => {
                setTimeout(() => this.error = "", 1000)
            });
        }
    },
    created() {
        this.getTheaters();
    }

}
</script>

<style scoped>

</style>
