<template>
    <div class="container">
        <h4>Booked Tickets</h4>
        <div class="my-3">
            <div class="table-responsive table-striped text-center">
                <table class="table">
                    <thead class="thead-dark">
                    <th scope="col">Id</th>
                    <th scope="col">User Name</th>
                    <th scope="col">City Name</th>
                    <th scope="col">Theater Name</th>
                    <th scope="col">Movie Name</th>
                    <th scope="col">Show</th>
                    <th scope="col">Seats No</th>
                    <th scope="col">Show Date</th>
                    <th scope="col">Booked Date</th>
                    <th scope="col" colspan="2">Action</th>
                    </thead>
                    <tbody>
                    <tr v-if="bookedTickets.length > 0" v-for="(booked,index) in bookedTickets" :key="index" :class="formatDate(booked.show_time_date) < formatDate(new Date()) ? 'bg-secondary' : ''">
                        <td>{{ ++index }}</td>
                        <td>{{ booked.name }}</td>
                        <td>{{ booked.city_name }}</td>
                        <td>{{ booked.theater_name }}</td>
                        <td>{{ booked.title }}</td>
                        <td>{{ booked.show }}</td>
                        <td>{{ booked.seats }}</td>
                        <td>{{ booked.show_time_date }}</td>
                        <td>{{ new Date(booked.created_at).toDateString() }}</td>
                        <td>
                            <button @click.prevent="cancelBookedTicket(booked.id)" class="btn btn-danger" :class="formatDate(booked.show_time_date) < formatDate(new Date()) ? 'disabled' : ''">Cancel</button>
                        </td>
                    </tr>
                    <tr v-if="bookedTickets.length == 0">
                        <td colspan="10">No Data Found</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "displayBookedTickets",
    data: function () {
        return {
            bookedTickets: [],
            classes:"bg-secondary",
        }
    },
    methods: {
        cancelBookedTicket: function (booked) {
            axios.delete('/bookTicket/'+booked)
                .then(response => {
                    this.bookedTickets = response.data;
                    this.getBookedTickets();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getBookedTickets: function () {
            axios.get('/bookTicket/get/')
                .then(response => {
                    this.bookedTickets = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        formatDate: function (date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }
    },
    created() {
        this.getBookedTickets();
    }
}
</script>

<style scoped>

</style>
