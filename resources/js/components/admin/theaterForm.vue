<template>
    <div class="container">
        <div :class="alert"  role="alert" v-if="error">
            {{ error }}
        </div>
        <form id="addTheater" @submit="addTheater">
            <div class="form-group">
                <label>Enter Theater Name</label>
                <input v-model="theater_id" type="hidden">
                <input v-model="theater_name" class="form-control" placeholder="Enter Theater Name">
            </div>
            <button class="btn btn-primary">{{ (theater_id === "") ? 'Add New Theater': 'Update Theater' }}</button>
        </form>
        <list-theaters v-if="!isLoading" :theaters="theaters" @updateTheater="onUpdateTheater" @deleteTheater="onDeleteTheater"></list-theaters>
        <loading :loading="isLoading"/>
    </div>
</template>

<script>
import Loading from "../loading";
import listTheaters from "./listTheaters";
export default {
    name: "theaterForm",
    components:{
        listTheaters,
        Loading
    },
    data: function () {
        return {
            theater_id:"",
            theater_name: "",
            error: "",
            alert: "alert alert-success",
            theaters: [],
            isLoading:false,
        }
    },
    methods: {
        addTheater: function (e) {
            if (this.theater_name) {
                if(this.theater_id === ""){
                    const theater = {theater_name: this.theater_name};
                    axios.post('/theater/store', theater)
                        .then(response => {
                            if(response.data.status === "error"){
                                this.theater_name = "";
                                this.theater_id = "";
                                this.alert = "alert alert-danger";
                                this.error = response.data.message;
                            }else if(response.data.status === "success"){
                                this.theater_name = "";
                                this.theater_id = "";
                                this.alert = "alert alert-success";
                                this.error = response.data.message;
                                this.getTheaters();
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 2000)
                    });
                }else{
                    const theater = {theater_name: this.theater_name,id:this.theater_id};
                    axios.put('/theater/'+this.theater_id, theater)
                        .then(response => {
                            if(response.data.status === "error"){
                                this.theater_name = "";
                                this.theater_id = "";
                                this.alert = "alert alert-danger";
                                this.error = response.data.message;
                            }else if(response.data.status === "success"){
                                this.theater_name = "";
                                this.theater_id = "";
                                this.alert = "alert alert-success";
                                this.error = response.data.message;
                                this.getTheaters();
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 2000)
                    });
                }
            } else {
                this.alert = "alert alert-danger"
                this.error = "Theater name is required!"
            }
            e.preventDefault();

        },
        getTheaters: async function () {
            this.isLoading = true;
            await axios.get('/theater/get')
                .then(response => {
                    this.theaters = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        },
        onUpdateTheater:function (theater){
            this.theater_id = theater.id;
            this.theater_name = theater.theater_name;
        },
        onDeleteTheater:function (theater){
            const theaterid = {id:theater.id};
            axios.delete('/theater/'+theater.id, theaterid)
                .then(response => {
                    if(response.data.status === "error"){
                        this.theater_name = "";
                        this.theater_id = "";
                        this.alert = "alert alert-danger";
                        this.error = response.data.message;
                    }else if(response.data.status === "success"){
                        this.theater_name = "";
                        this.theater_id = "";
                        this.alert = "alert alert-success"
                        this.error = "Theater Deleted Successfully";
                        this.getTheaters();
                    }
                })
                .catch(error => {
                    console.log(error);
                }).finally(() => {
                setTimeout(() => this.error = "", 2000)
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
