<template>
    <div class="container">
        <button @click="revert" :class="btnTextColor">{{ btnText }}</button>
        <div :class="alert" class="w-50" role="alert" v-if="error">
            {{ error }}
        </div>
        <form class="mt-3" id="addCast" @submit="addCast" v-if="show">
            <div class="form-group w-50">
                <label>Enter Cast Name</label>
                <input v-model="cast_id" type="hidden">
                <input v-model="name" type="text" class="form-control" placeholder="Enter Cast Name">
            </div>
            <div class="form-group w-50">
                <label>Enter Cast DOB</label>
                <input v-model="date_of_birth" type="date" class="form-control" placeholder="Enter Cast DOB">
            </div>
            <div class="form-group w-50">
                <label>Enter Cast Bio</label>
                <textarea v-model="bio" rows="5" cols="10" class="form-control" placeholder="Enter Cast Bio"></textarea>
            </div>
            <button class="btn btn-primary">{{ castButton }}</button>
        </form>
        <list-casts v-if="!show" :casts="casts" @updateCast="onUpdateCast" @deleteCast="onDeleteCast"></list-casts>
    </div>
</template>

<script>
import listCasts from "./listCasts";

export default {
    name: "castForm",
    components: {
        listCasts
    },
    data: function () {
        return {
            cast_id: "",
            name: "",
            bio: "",
            date_of_birth: "",
            error: "",
            alert: "alert alert-success",
            casts: [],
            show: false,
            btnText: "Add Cast",
            btnTextColor: "btn btn-primary",
            castButton:"Add New Casts",
        }
    },
    methods: {
        changeCastButton:function (){
            this.castButton = "Update Casts";
            if(this.cast_id === ""){
                this.castButton = "Add New Casts";
            }
        },
        revert: function () {
            if(this.show === false){
                this.btnText = "Close";
                this.btnTextColor = "btn btn-danger";
            }else{
                this.cast_id = "";
                this.name = "";
                this.bio = "";
                this.date_of_birth = "";
                this.btnText = "Add Cast";
                this.btnTextColor = "btn btn-primary";
            }
            this.changeCastButton();
            this.show = !this.show;
        },
        addCast: function (e) {
            if (this.name && this.bio && this.date_of_birth) {
                if (this.cast_id === "") {
                    const cast = {
                        name: this.name,
                        bio: this.bio,
                        date_of_birth: this.date_of_birth
                    };
                    axios.post('/api/cast/store', cast)
                        .then(response => {
                            this.cast_id = "";
                            this.name = "";
                            this.bio = "";
                            this.date_of_birth = "";
                            this.alert = "alert alert-success";
                            this.error = "Cast Added Successfully";
                            this.revert();
                            this.getCasts();
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                } else {
                    const cast = {
                        name: this.name,
                        bio: this.bio,
                        date_of_birth: this.date_of_birth
                    };
                    axios.put('/api/cast/' + this.cast_id, cast)
                        .then(response => {
                            this.cast_id = "";
                            this.name = "";
                            this.bio = "";
                            this.date_of_birth = "";
                            this.alert = "alert alert-success";
                            this.error = "Cast Update Successfully";
                            this.getCasts();
                            this.changeCastButton();
                            this.revert();
                        })
                        .catch(error => {
                            console.log(error);
                        }).finally(() => {
                        setTimeout(() => this.error = "", 1000)
                    });
                }
            }
            if (this.name === "") {
                this.alert = "alert alert-danger"
                this.error = "Cast name is required!"
            } else if (this.bio === "") {
                this.alert = "alert alert-danger"
                this.error = "Cast bio is required!"
            } else if (this.date_of_birth === "") {
                this.alert = "alert alert-danger"
                this.error = "Cast DOB is required!"
            }
            e.preventDefault();

        },
        onUpdateCast: function (cast) {
            this.cast_id = cast.id;
            this.name = cast.name;
            this.bio = cast.bio;
            this.date_of_birth = cast.date_of_birth;
            this.changeCastButton();
            this.revert();
        },
        onDeleteCast: function (cast) {
            const castid = {id: cast.id};
            axios.delete('/api/cast/' + cast.id, castid)
                .then(response => {
                    this.alert = "alert alert-success";
                    this.error = "Cast Deleted Successfully";
                    this.getCasts();
                })
                .catch(error => {
                    console.log(error);
                }).finally(() => {
                setTimeout(() => this.error = "", 1000)
            });
        }, getCasts: function () {
            axios.get('/api/cast/get')
                .then(response => {
                    this.casts = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },
    created() {
        this.getCasts();
    }
}
</script>

<style scoped>

</style>
