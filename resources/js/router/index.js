import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import routes from './route'

const router = new VueRouter({
    history: true,
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('user')
    const user = JSON.parse(loggedIn);
    if (to.matched.some(record => record.meta.auth) && !loggedIn) {
        next('/login')
        return
    } else {
        if (to.matched.some(record => record.meta.auth) && user.user.is_admin == to.matched.some(record => record.meta.admin) && loggedIn) {
            if (to.matched[0].path === "" && user.user.is_admin == 0) {
                next('/home')
                return
            } else if (to.matched[0].path === "" && user.user.is_admin == 1) {
                next('/admin/home')
                return
            }
            next()
            return
        } else {
            if (to.matched.some(record => record.meta.auth) && loggedIn && user.user.is_admin == 0) {
                next('/home')
                return
            } else if (to.matched.some(record => record.meta.auth) && loggedIn && user.user.is_admin == 1) {
                next('/admin/home')
                return
            }
        }
    }
    next()
});

export default router

