import Home from './components/home'
import App from './components/app'
import displayView from "./components/displayView";

//admin path
import cityForm from "./components/admin/cityForm"
import Dashboard from './components/admin/dashboard'
import theaterForm from "./components/admin/theaterForm";
import castForm from "./components/admin/castForm";
import listCasts from "./components/admin/listCasts";
import assignTheaterForm from "./components/admin/assignMovieForm";
import movieForm from "./components/admin/movieForm";
import movieDetails from "./components/movieDetails";
import assignCastMovieForm from "./components/admin/assignCastMovieForm";
import castDetails from "./components/castDetails";
import displaySeat from "./components/displaySeat";
import confirmBookSeats from "./components/confirmBookSeats";
import displayBookedTickets from "./components/displayBookedTickets";
import displayAllUserBookTickets from "./components/admin/displayAllUserBookTickets";
import login from "./components/login";

const routes = [
    {
        path: '/',
        name: 'App',
        component: App,
    },
    {
        path: '/login',
        name: 'login',
        component: login,
    },
    {
        path: '/home',
        name: 'Home',
        component: Home,
    },
    {
        path: '/user/movie/:id',
        name: 'movieDetails',
        component: movieDetails,
    },
    {
        path: '/movie/list',
        name: 'displayView',
        component: displayView,
    },
    {
        path: '/admin/home',
        name: 'DashBoard',
        component: Dashboard,
    },
    {
        path: '/movie/create',
        name: 'movieForm',
        component: movieForm,
    },
    {
        path: '/movie/show',
        name: 'displayView',
        component: displayView,
    },
    {
        path: '/city/create',
        name: 'cityForm',
        component: cityForm,
    },
    {
        path: '/theater/create',
        name: 'theaterForm',
        component: theaterForm,
    }, {
        path: '/theater/assign/create',
        name: 'assignTheaterForm',
        component: assignTheaterForm,
    },
    {
        path: '/cast/create',
        name: 'castForm',
        component: castForm,
    }, {
        path: '/cast/list/',
        name: 'listCasts',
        component: listCasts,
    }, {
        path: '/cast/assign/create',
        name: 'assignCastMovieForm',
        component: assignCastMovieForm,
    }, {
        path: '/user/cast/:id',
        name: 'castDetails',
        component: castDetails,
    }, {
        path: '/bookTicket',
        name: 'displaySeat',
        component: displaySeat,
    }, {
        path: '/bookTicket/confirm',
        name: 'confirmBookSeats',
        component: confirmBookSeats,
    }
    , {
        path: '/user/booked',
        name: 'displayBookedTickets',
        component: displayBookedTickets,
    } ,{
        path: '/bookTicket/booked',
        name: 'displayAllUserBookTickets',
        component: displayAllUserBookTickets,
    }
];

export default routes;
