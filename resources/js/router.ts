import Vue from "vue";
import VueRouter, {RawLocation} from "vue-router";
import store from "./store";

import Home from "./views/Home.vue";
import Login from "./views/Login.vue";
import Passwords from "./views/Passwords.vue";

Vue.use(VueRouter);

const router = new VueRouter({
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
            path: '/passwords',
            name: 'passwords',
            component: Passwords,
            meta: {
                requiresAuth: true,
            }
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

export const loginRoute = {name: 'login'} as RawLocation;
export const homeRoute = {name: 'home'} as RawLocation;

router.beforeEach(((to, from, next) => {
    const authenticated = store.getters['auth/isAuthenticated'];
    const requiresGuest = to.matched.some(record => record.meta.requiresGuest);
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (authenticated) {
        if (requiresGuest)
            next(homeRoute);
        else
            next();
    } else {
        if (requiresAuth)
            next(loginRoute);
        else
            next();
    }
}));

export default router;
