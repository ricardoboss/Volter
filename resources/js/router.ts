import Vue from "vue"
import VueRouter from "vue-router"
import Home from "./views/Home.vue"
import Settings from "./views/Settings.vue"

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",

    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/settings',
            name: 'settings',
            component: Settings
        }
    ],
})
