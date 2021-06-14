<template>
    <div class="container">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-none overflow-hidden md:max-w-2xl">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <img class="h-48 w-full object-cover md:h-full md:w-48" :src="cast.image_path" :alt="cast.name">
                </div>
                <div class="p-8">
                    <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{ cast.name }}</div>
                    <div class=" tracking-wide text-sm  font-semibold">Date of Birth :{{ new
                        Date(cast.dob).toDateString() }}
                    </div>
                    <p class="mt-2 text-gray-500">{{ cast.bio }}</p>
                </div>
            </div>
        </div>

        <div class="container my-3 p-3 text-dark rounded-xl" style="background-color: #b3c1ca;">
            <h5 class=""><b>Cast Movie :</b></h5>
            <div class="container p-1 no-scrollbar"
                 style="width:100%;height:auto;overflow-x:auto;white-space: nowrap;overflow-y:hidden;">
                <div style="display: inline-block;"
                     class="text-center m-1 p-2"
                     v-for="(movie,index) in movies"
                     :key="index">
                    <div class="max-w-xs bg-white rounded-xl">
                        <router-link :to="'/user/movie/'+movie.id" class="text-dark" style="text-decoration: none;">
                            <img :src="movie.image_path" height="200px" class="card-img-top" :alt="movie.title">
                            <div class="card-body">
                                <h4 class="h5 text-wrap" style="color:#101820ff;text-shadow: 0 0 20px black">{{ movie.title }}</h4>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <loading :loading="isLoading"/>
    </div>
</template>

<script>
import Loading from "./loading";

export default {
    name: "castDetails",
    data: function () {
        return {
            cast: {
                id: "",
                name: "",
                bio: "",
                dob: "",
                image_path: "",
            },
            movies: [],
            city: [],
            isLoading: false,
        }
    },
    components: {
        Loading
    },
    methods: {
        getCast: async function () {
            this.isLoading = true;
            await axios.get('/cast/' + this.$route.params.id)
                .then(response => {
                    this.cast.id = response.data.id;
                    this.cast.name = response.data.name;
                    this.cast.bio = response.data.bio;
                    this.cast.dob = response.data.date_of_birth;
                    this.cast.image_path = response.data.image_path;
                    this.getCastMovies(response.data.id);
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        },
        getCastMovies: function (id) {
            this.isLoading = true;
            axios.get('/castMovie/movie/' + id)
                .then(response => {
                    this.movies = response.data
                })
                .catch(error => {
                    console.log(error);
                })
            this.isLoading = false;
        }
    },
    created() {
        this.getCast();
    }
}
</script>

<style scoped>
.no-scrollbar::-webkit-scrollbar{
    height: 8px;
}
.no-scrollbar::-webkit-scrollbar-track {
    box-shadow: inset 0 0 3px #101820ff;
    border-radius: 10px;
}
.no-scrollbar::-webkit-scrollbar-thumb {
    background: rgb(0, 32, 63);
    border-radius: 10px;
}
</style>
