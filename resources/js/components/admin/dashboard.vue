<template>
    <div class="container">
        <div v-if="!isLoading">
            <div class="d-flex bd-highlight mb-3 justify-content-center flex-wrap">
                <router-link to="/movie/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                        <div class="h4">Total Movies</div>
                        <div class="h5">{{ totalMovies }}</div>
                </router-link>
                <router-link to="/cast/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                    <div>
                        <div class="h4">Total Casts</div>
                        <div class="h5">{{ totalCasts }}</div>
                    </div>
                </router-link>
                <router-link to="/theater/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                    <div>
                        <div class="h4">Total Theaters</div>
                        <div class="h5">{{ totalTheaters }}</div>
                    </div>
                </router-link>
                <router-link to="/bookTicket/booked/" class="links flex-fill border border-primary boxes p-2 m-2">
                    <div>
                        <div class="h4">Total Booked Tickets</div>
                        <div class="h5">{{ totalBookedTickets }}</div>
                    </div>
                </router-link>
            </div>
            <div class="d-flex bd-highlight mb-3 justify-content-center flex-wrap">
                <router-link to="/city/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                    <div>
                        <div class="h4">Total Cities</div>
                        <div class="h5">{{ totalCities }}</div>
                    </div>
                </router-link>
                <router-link to="/movie/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                    <div>
                        <div class="h4">Total Released Movies</div>
                        <div class="h5">{{ totalRelease }}</div>
                    </div>
                </router-link>
                <router-link to="/movie/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                    <div>
                        <div class="h4">Total Upcoming Movie</div>
                        <div class="h5">{{ totalUpComing }}</div>
                    </div>
                </router-link>
            </div>
        </div>
        <loading :loading="isLoading" />
    </div>
</template>

<script>
import displayView from "../displayView";
import Loading from "../loading";

export default {
    name: "dashboard",
    components: {
        Loading
    },
    data: function () {
        return {
            totalMovies: 0,
            totalCasts: 0,
            totalTheaters: 0,
            totalCities: 0,
            totalRelease: 0,
            totalUpComing: 0,
            totalBookedTickets: 0,
            isLoading: false,
        }
    },
    methods: {
        getTotalsForDashboard: async function () {
            this.isLoading = true;
            await axios.get('/total/dashboard/')
                .then(response => {
                    this.totalCities = response["data"]["cities"];
                    this.totalTheaters = response["data"]["theaters"];
                    this.totalCasts = response["data"]["casts"];
                    this.totalMovies = response["data"]["movies"];
                    this.totalRelease = response["data"]["releaseMovie"];
                    this.totalUpComing = response["data"]["upcomingMovie"];
                    this.totalBookedTickets = response["data"]["totalBookedTickets"];
                })
                .catch(error => {
                    console.log(error);
                });
            this.isLoading = false;
        }
    },
    created() {
        this.getTotalsForDashboard();
    }
}
</script>

<style scoped>

.links {
    text-decoration: none;
    background-color: #ADEFD1FF;
    color: #00203FFF;
}

h4 {
    margin: auto;
    font-weight: 300;
}

.boxes {
    width: 150px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px #000000;
    min-height: 100px;
}
</style>
