<template>
    <div class="container">
        <div class="card p-3">
            <div class="d-md-flex m-2">
                <h4>Movie : {{ movie.name }}</h4>
                <div @click="addBookTickets" class="btn btn-primary ml-auto mx-2" v-if="selectedSeats.length >= 1">
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
                <div class="d-flex bd-highlight justify-content-center flex-wrap" id="content">
                    <div v-for="box in 50" @click="getSeats(box)" :id="box"
                         class="border p-2 m-3 text-center"
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
            selectedSeats:[],
            onlySeats: [],
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
            disabled: "bg-danger text-secondary"
        }
    },
    methods: {

        addBookTickets: function () {
            const bookTickets = {
                city_id: this.city.id,
                theater_id: this.theater.id,
                movie_id: this.movie.id,
                show: this.show,
                seats: this.seats
            };
            axios.post('/api/bookTicket/store', bookTickets)
                .then(response => {
                    //this.seats = response.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getBookedSeat: function () {
            const data = {
                city_id: this.city.id,
                theater_id: this.theater.id,
                movie_id: this.movie.id,
                show: this.show,
            }
            axios.post('/api/bookTicket/getSeats', data)
                .then(response => {
                    this.seats = response.data;
                    for (const i in this.seats) {
                        this.onlySeats = this.seats[i].seats.split("|");
                    }
                    this.closeBookedSeat();
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getSeats: function (seat) {
            if($("#" + seat).hasClass("bg-danger text-light")){
                alert("This seat is already booked! Please Choose another seat!");
            }else{
                if ($("#" + seat).hasClass("bg-light text-dark")) {
                    if (this.selectedSeats.length === 5) {
                        alert("you can select maximum 5 tickets");
                    } else {
                        $("#" + seat).removeClass("bg-light text-dark");
                        $("#" + seat).addClass("bg-dark text-light");
                        this.selectedSeats.push(seat);
                    }
                } else {
                    $("#" + seat).removeClass("bg-dark text-light");
                    $("#" + seat).addClass("bg-light text-dark");
                    this.selectedSeats.pop(seat);

                }
            }
        },
        closeBookedSeat:function () {
            for(let i=1;i<=50;i++){
                if(this.onlySeats.includes(i.toString())){
                    $("#" + i).addClass("bg-danger text-light")
                }else{
                    $("#" + i).addClass("bg-light text-dark")
                }
            }
        }
    },
    created() {
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
        this.getBookedSeat();

    }
}
</script>

<style scoped>

</style>
