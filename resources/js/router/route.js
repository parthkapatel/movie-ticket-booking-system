import Home from "../components/home";
import movieDetails from "../components/movieDetails";
import displayView from "../components/displayView";
import Dashboard from "../components/admin/dashboard";
import movieForm from "../components/admin/movieForm";
import cityForm from "../components/admin/cityForm";
import theaterForm from "../components/admin/theaterForm";
import assignTheaterForm from "../components/admin/assignMovieForm";
import castForm from "../components/admin/castForm";
import listCasts from "../components/admin/listCasts";
import assignCastMovieForm from "../components/admin/assignCastMovieForm";
import castDetails from "../components/castDetails";
import displaySeat from "../components/displaySeat";
import displayBookedTickets from "../components/displayBookedTickets";
import displayAllUserBookTickets from "../components/admin/displayAllUserBookTickets";

const routes = [
     {
         path: '/',
         meta: {
             auth: true
         },
     },
    {
        path: '/login',
        name: 'login',
        component: () => import('../components/login.vue'),
    }, {
        path: '/register',
        name: 'register',
        component: () => import('../components/register.vue'),
    },
    {
        path: '/home',
        name: 'Home',
        component: Home,
        meta: {
            auth: true,
            admin: 0,
        },
    },
    {
        path: '/user/movie/:id',
        name: 'movieDetails',
        component: movieDetails,
        meta: {
            auth: true,
            admin: 0,
        },
    },{
        path: '/user/cast/:id',
        name: 'castDetails',
        component: castDetails,
        meta: {
            auth: true,
            admin: 0,
        },
    }, {
        path: '/bookTicket',
        name: 'displaySeat',
        component: displaySeat,
        meta: {
            auth: true,
            admin: 0,
        },
    }
    , {
        path: '/user/booked',
        name: 'displayBookedTickets',
        component: displayBookedTickets,
        meta: {
            auth: true,
            admin: 0,
        },
    },
    {
        path: '/movie/list',
        name: 'displayView',
        component: displayView,
        meta: {
            auth: true,
            admin: 1,
        },
    },
    {
        path: '/admin/home',
        name: 'DashBoard',
        component: Dashboard,
        meta: {
            auth: true,
            admin: 1,
        },
    },
    {
        path: '/movie/create',
        name: 'movieForm',
        component: movieForm,
        meta: {
            auth: true,
            admin: 1,
        },
    },
    {
        path: '/movie/show',
        name: 'displayView',
        component: displayView,
        meta: {
            auth: true,
            admin: 1,
        },
    },
    {
        path: '/city/create',
        name: 'cityForm',
        component: cityForm,
        meta: {
            auth: true,
            admin: 1,
        },
    },
    {
        path: '/theater/create',
        name: 'theaterForm',
        component: theaterForm,
        meta: {
            auth: true,
            admin: 1,
        },
    }, {
        path: '/theater/assign/create',
        name: 'assignTheaterForm',
        component: assignTheaterForm,
        meta: {
            auth: true,
            admin: 1,
        },
    },
    {
        path: '/cast/create',
        name: 'castForm',
        component: castForm,
        meta: {
            auth: true,
            admin: 1,
        },
    }, {
        path: '/cast/list/',
        name: 'listCasts',
        component: listCasts,
        meta: {
            auth: true,
            admin: 1,
        },
    }, {
        path: '/cast/assign/create',
        name: 'assignCastMovieForm',
        component: assignCastMovieForm,
        meta: {
            auth: true,
            admin: 1,
        },
    },  {
        path: '/bookTicket/booked',
        name: 'displayAllUserBookTickets',
        component: displayAllUserBookTickets,
        meta: {
            auth: true,
            admin: 1,
        },
    }
];

export default routes;
