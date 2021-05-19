<template>
    <div class="container">
        <div class="card p-3">
            <div class="d-flex m-2">
                <h4>Movie : {{ movie.name }}</h4>
                <div @click="addBookTickets" class="btn btn-primary ml-auto mx-2" v-if="seats.length >= 1">
                    Book
                </div>
            </div>
            <div class="container text-danger">
                you can select maximum 5 seats and minimum 1 seat
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">{{ city.name }}</li>
                    <li class="breadcrumb-item">{{ theater.name }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ show }}</li>
                </ol>
            </nav>
            <div class="container" style="min-height:500px;border-radius:5px;background-color: #e9ecef;">
                <div class="d-flex bd-highlight justify-content-center flex-wrap">
                    <div @click="getSeats(box)" :id="box" v-for="box in 50" class="border p-2 bg-light m-3 text-center"
                         style="width: 75px;">{{ box }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "displaySeat",
    data: function () {
        return {
            seats: [],
            city: {
                id: "",
                name: ""
            },
            theater: {
                id: "",
                name: "",
            },
            movie: {
                id: "",
                name: "",
            },
            show: "",
        }
    },
    methods: {
        addBookTickets: function () {
            const bookTickets = {
                city_id: this.city.id,
                theater_id: this.theater.id,
                movie_id: this.movie.id,
                show: this.show,
                seats:this.seats
            };
            axios.post('/api/bookTicket/store', bookTickets)
                .then(response => {
                    console.log(response);
                    //this.seats = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getBookedSeat: function () {
            axios.get('/api/bookTicket/get')
                .then(response => {
                    console.log(response);
                    //this.seats = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getSeats: function (seat) {
            if ($("#" + seat).hasClass("bg-dark text-light")) {
                $("#" + seat).removeClass("bg-dark text-light");
                this.seats.pop(seat);
            } else {
                if (this.seats.length === 5) {
                    alert("you can select maximum 5 tickets");
                } else {
                    $("#" + seat).addClass("bg-dark text-light");
                    this.seats.push(seat);
                }
            }
            console.log(this.seats);
        }

    },
    mounted() {
        window.addEventListener('beforeunload', function (event) {
            event.returnValue = 'If you refresh the page data are removed'
        })
        this.city["id"] = sessionStorage.getItem("city_id");
        this.city["name"] = sessionStorage.getItem("city_name");
        this.theater["id"] = sessionStorage.getItem("theater_id");
        this.theater["name"] = sessionStorage.getItem("theater_name");
        this.movie["id"] = sessionStorage.getItem("movie_id");
        this.movie["name"] = sessionStorage.getItem("movie_name");
        this.show = sessionStorage.getItem("show");
    },
    created() {
        this.getBookedSeat();

    }
}
</script>

<style scoped>

</style>
