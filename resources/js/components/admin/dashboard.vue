<template>
    <div class="container">
        <div class="d-flex bd-highlight mb-3 justify-content-center flex-wrap">
            <router-link to="/movie/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                <div>
                    <h3>Total Movies</h3>
                    <h4>{{ totalMovies }}</h4>
                </div>
            </router-link>
            <router-link to="/cast/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                <div>
                    <h3>Total Casts</h3>
                    <h4>{{ totalCasts }}</h4>
                </div>
            </router-link>
            <router-link to="/theater/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                <div>
                    <h3>Total Theaters</h3>
                    <h4>{{ totalTheaters }}</h4>
                </div>
            </router-link>
            <router-link to="/bookTicket/booked/" class="links flex-fill border border-primary boxes p-2 m-2">
                <div>
                    <h3>Total Booked Tickets</h3>
                    <h4>{{ totalBookedTickets }}</h4>
                </div>
            </router-link>
        </div>
        <div class="d-flex bd-highlight mb-3 justify-content-center flex-wrap">
            <router-link to="/city/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                <div>
                    <h3>Total Cities</h3>
                    <h4>{{ totalCities }}</h4>
                </div>
            </router-link>
            <router-link to="/movie/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                <div>
                    <h3>Total Released Movies</h3>
                    <h4>{{ totalRelease }}</h4>
                </div>
            </router-link>
            <router-link to="/movie/create/" class="links flex-fill border border-primary boxes p-2 m-2">
                <div>
                    <h3>Total Upcoming Movie</h3>
                    <h4>{{ totalUpComing }}</h4>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "dashboard",
    data: function () {
        return {
            totalMovies: 0,
            totalCasts: 0,
            totalTheaters: 0,
            totalCities: 0,
            totalRelease: 0,
            totalUpComing: 0,
            totalBookedTickets:0,
        }
    },
    methods: {
        getTotalsForDashboard: function () {
            axios.get('/api/total/dashboard/')
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
        }
    },
    created() {
        this.getTotalsForDashboard();
    }
}
</script>

<style scoped>
.links {
    color: black;
    text-decoration: none;
}
h4{
    margin:auto;
    font-width: 300;
}
.boxes {
    width: 150px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px #000000;
    min-height: 100px;
}
</style>
