import Vue from "vue"
import VueRouter from "vue-router"
import Home from "./views/Home.vue"
import Settings from "./views/Settings.vue"
import Login from "./views/Login.vue"
import store from "./store"

Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: "active",

    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: '/settings',
            name: 'settings',
            component: Settings,
            meta: {}
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                requiresGuest: true,
            }
        }
    ],
});

/**
 * handle guest/authenticated-only routes
 */
router.beforeEach((to, from, next) => {
    let authenticated = store.getters['auth/isAuthenticated'];
    let requiresGuest = to.matched.some(record => record.meta.requiresGuest);
    let requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (requiresAuth) {
        if (authenticated) {
            next();
        } else {
            console.log("Auth is required");

            next({name: 'login'});
        }
    } else if (requiresGuest) {
        if (authenticated) {
            console.log("Guest is required");

            next({name: 'home'});
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
