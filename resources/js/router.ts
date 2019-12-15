import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";

import Home from "./views/Home.vue";
import Login from "./views/Login.vue";
import Passwords from "./views/Passwords.vue";
import NotFound from "./views/NotFound.vue";

Vue.use(VueRouter);

export const loginRoute = {name: 'login', path: '/login'};
export const homeRoute = {name: 'home', path: '/'};

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: "active",

    routes: [
        {
            path: homeRoute.path,
            name: homeRoute.name,
            component: Home,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: loginRoute.path,
            name: loginRoute.name,
            component: Login,
            meta: {
                requiresGuest: true,
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
            path: '*',
            component: NotFound
        }
    ],
});

router.beforeEach((to, from, next) => {
    const authenticated = store.getters['auth/isAuthenticated'];
    const requiresGuest = to.matched.some(record => record.meta.requiresGuest);
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (authenticated) {
        if (requiresGuest)
            next(homeRoute);
        else
            next();
    } else {
        if (requiresAuth) {
            next({name: loginRoute.name, replace: true, query: {continue_with: to.path}});
        } else
            next();
    }
});

export default router;
