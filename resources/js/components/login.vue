<template>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form method="POST" @submit.prevent="login">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>

                                <div class="col-md-6">
                                    <input id="email"  type="email" name="email" v-model="email" class="form-control " value="" required
                                           autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="password" class="form-control " name="password" required
                                           autocomplete="current-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>
                            </div>
                            <div class="alert alert-danger my-3" role="alert" v-if="message">
                                {{ message }}
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
    name: "login",
    data() {
        return {
            email: '',
            password: '',
            message:'',
        }
    },

    methods: {
        login() {
            this.$store
                .dispatch('login', {
                    email: this.email,
                    password: this.password
                })
                .then((res) => {
                    if(res.status === "error"){
                        this.message = res.message
                    }else{
                        this.message = "";
                    }
                    //this.$router.push({name: 'About'})
                })
                .catch(err => {
                    console.log(err)
                })
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
