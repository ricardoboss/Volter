import Vue from "vue"
import VueRouter from "vue-router"

import Home from "./views/Home.vue"

Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: "active",

    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        }
    ],
});

export default router;
