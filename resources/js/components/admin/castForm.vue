<template>
    <div class="container">
        <button @click="revert" :class="btnTextColor">{{ btnText }}</button>
        <div :class="alert" class="w-50" role="alert" v-if="error">
            {{ error }}
        </div>
        <form class="mt-3" enctype="multipart/form-data" id="addCast" @submit="addCast" v-if="show">
            <div class="form-group">
                <label>Enter Cast Name</label>
                <input v-model="cast_id" type="hidden">
                <input v-model="name" type="text" class="form-control" placeholder="Enter Cast Name">
            </div>
            <div class="form-group ">
                <label>Enter Cast DOB</label>
                <input v-model="date_of_birth" type="date" class="form-control" placeholder="Enter Cast DOB">
            </div>
            <div class="form-group ">
                <label>Enter Cast Bio</label>
                <textarea v-model="bio" rows="5" cols="10" class="form-control" placeholder="Enter Cast Bio"></textarea>
            </div>
            <div class="form-group">
                <label>Select Cast Image</label>
                <input  type="file" v-on:change="onChange" accept=".jpeg,.jpg" class="form-control" placeholder="Select Cast Image">
            </div>
            <button class="btn btn-primary">{{ castButton }}</button>
        </form>
        <list-casts v-if="!show || !isLoading" :casts="casts" @updateCast="onUpdateCast"
                    @deleteCast="onDeleteCast"></list-casts>
        <loading :loading="isLoading"/>
    </div>
</template>

<script>
import listCasts from "./listCasts";
import Loading from '../loading';

export default {
    name: "castForm",
    components: {
        listCasts,
        Loading
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
            castButton: "Add New Casts",
            isLoading: false,
            cast_image:"",
        }
    },
    methods: {
        onChange(e) {
            this.cast_image = e.target.files[0];
        },
        changeCastButton: function () {
            this.castButton = "Update Casts";
            if (this.cast_id === "") {
                this.castButton = "Add New Casts";
            }
        },
        revert: function () {
            if (this.show === false) {
                this.btnText = "Close";
                this.btnTextColor = "btn btn-danger";
            } else {
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
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                e.preventDefault();

                if (this.cast_id === "") {
                    let data = new FormData();
                    data.append('name', this.name);
                    data.append('bio', this.bio);
                    data.append('date_of_birth', this.date_of_birth);
                    data.append('cast_image', this.cast_image);
                    axios.post('/cast/store', data,config)
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
                    let data = new FormData();
                    data.append('name', this.name);
                    data.append('bio', this.bio);
                    data.append('date_of_birth', this.date_of_birth);
                    data.append('cast_image', this.cast_image);
                    axios.post('/cast/' + this.cast_id, data,config)
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
            axios.delete('/cast/' + cast.id, castid)
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
        },
        getCasts: async function () {
            this.isLoading = true;
            await axios.get('/cast/get')
                .then(response => {
                    this.casts = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        },
    },
    created() {
        this.getCasts();
    }
}
</script>

<style scoped>

</style>
