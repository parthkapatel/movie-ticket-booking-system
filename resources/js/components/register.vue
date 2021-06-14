<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <div class="alert" :class="success" role="alert" v-if="message">{{ message }}</div>
                        <form method="POST" @submit.prevent="register">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" name="name" v-model="name" class="form-control "
                                           value="" required
                                           autocomplete="name" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" name="email" v-model="email" class="form-control "
                                           value="" required
                                           autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="password" class="form-control "
                                           name="password" required
                                           autocomplete="current-password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirmPassword" class="col-md-4 col-form-label text-md-right">Confirm
                                    Password</label>

                                <div class="col-md-6">
                                    <input id="confirmPassword" type="password" v-model="confirmPassword"
                                           class="form-control " name="confirmPassword" required
                                           autocomplete="current-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "register",
    data() {
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: '',
            message: '',
            success: 'alert-danger',
        }
    },

    methods: {
        register() {
            if(this.password.length < 8 || this.confirmPassword.length < 8) {
                this.message = "Password length must be 8 character";
            }else if (this.password !== this.confirmPassword) {
                this.message = "password does not match";
            }else {
                this.message = '';
                this.$store
                    .dispatch('register', {
                        name: this.name,
                        email: this.email,
                        password: this.password
                    })
                    .then((response) => {
                        this.success = "alert-danger";
                        if(response.data.status === "error"){
                            this.message = response.data.error;
                        }else if(response.data.status === "success"){
                            this.success = "alert-success";
                            this.message = response.data.message;
                            this.name = '';
                            this.email = '';
                            this.password = '';
                            this.confirmPassword = '';
                            setTimeout(function (){
                                location.href = "/login";
                            },500);
                        }else{
                            this.message = "something is wrong";
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        }
    }
}
</script>

<style scoped>
.container{
    color: #ADEFD1FF;
}
.card{
    background-color: #00203FFF;
}
.btn{
    background-color: #F2AA4CFF;
    border-color: #F2AA4CFF;
    color:#101820ff;
}
</style>
