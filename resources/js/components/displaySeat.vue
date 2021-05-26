<template>
    <div class="container">
        <div class="card p-3">
            <div class="d-md-flex m-2">
                <h4>Movie : {{ movie.name }}</h4>
                <div id="btnBook" @click="addBookTickets" class="btn btn-primary ml-auto mx-2"
                     v-if="selectedSeats.length >= 1">
                    Book
                </div>
            </div>
            <div class="container text-danger">
                you can select maximum 5 seats and minimum 1 seat
            </div>
            <div class="container w-50 my-2" v-if="!errorMessage">
                <label>Select Show Date :</label>
                <input class="form-control" id="date" type="date" @change="getBookedSeat" v-model="show_time_date"
                       name="show_time_date">
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">{{ city.name }}</li>
                    <li class="breadcrumb-item">{{ theater.name }}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{ show }}</li>
                </ol>
            </nav>
            <div class="container p-2" style="min-height:500px;border-radius:5px;background-color: #e9ecef;">
                <div class="alert alert-success text-center" v-if="successMessage">{{ successMessage }}</div>
                <div class="alert alert-danger text-center" v-if="errorMessage">{{ errorMessage }}</div>
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
            selectedSeats: [],
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
            disabled: "bg-danger text-secondary",
            show_time_date: '',
            successMessage: '',
            errorMessage: '',
        }
    },
    methods: {
        addBookTickets: function () {
            if (this.show_time_date === "") {
                alert("Please select show date");
            } else {
                const bookTickets = {
                    city_id: this.city.id,
                    theater_id: this.theater.id,
                    movie_id: this.movie.id,
                    show: this.show,
                    seats: this.selectedSeats,
                    show_time_date: this.show_time_date,
                };
                axios.post('/bookTicket/store', bookTickets)
                    .then(response => {
                        if (response.data) {
                            this.successMessage = "Your seat is booked successfully";
                        }
                        this.selectedSeats = [];
                        this.getBookedSeat();
                        setTimeout(function () {
                            this.successMessage = "";
                            location.href = "/user/booked";
                        }, 1500);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
        getBookedSeat: function () {
            const data = {
                city_id: this.city.id,
                theater_id: this.theater.id,
                movie_id: this.movie.id,
                show: this.show,
                time: this.show_time_date,
            }
            axios.post('/bookTicket/getSeats', data)
                .then(response => {
                    this.seats = response.data;
                    let str = "";
                    this.onlySeats = [];
                    for (let i = 0; i < this.seats.length; i++) {
                        for (let j = 0; j < this.seats[i].seats.length; j++) {
                            if (this.seats[i].seats[j] === "|") {
                                this.onlySeats.push(str);
                                str = "";
                                continue;
                            } else {
                                str += this.seats[i].seats[j];
                            }
                        }
                        this.onlySeats.push(str);
                        str = "";
                    }
                    this.closeBookedSeat();
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getSeats: function (seat) {
            if ($("#" + seat).hasClass("bg-danger text-light")) {
                alert("This seat is already booked! Please Choose another seat!");
            } else {
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
        closeBookedSeat: function () {
            if (this.onlySeats.length === 50) {
                this.errorMessage = "This Show is full";
            }
            for (let i = 0; i <= 50; i++) {
                if (this.onlySeats.includes(i.toString())) {
                    if ($("#" + i).hasClass("bg-dark text-light")) {
                        $("#" + i).removeClass("bg-dark text-light");
                    }
                    if ($("#" + i).hasClass("bg-light text-dark")) {
                        $("#" + i).removeClass("bg-light text-dark");
                    }
                    $("#" + i).addClass("bg-danger text-light");
                } else {
                    if ($("#" + i).hasClass("bg-danger text-light")) {
                        $("#" + i).removeClass("bg-danger text-light");
                    }
                    $("#" + i).addClass("bg-light text-dark");
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
    },
    mounted() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0 so need to add 1 to make it 1!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        today = yyyy + '-' + mm + '-' + dd;
        $("#date").attr("min", today);
    },
}
</script>

<style scoped>

</style>
