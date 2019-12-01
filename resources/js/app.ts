import "../sass/app.scss" // SCSS styles
import "./bootstrap.ts" // Load all Javascript utilities and other dependencies.
import Vue from "vue" // Load VueJS and all the components
import router from "./router" // Load VueRouter
import store from "./store" // Load Vuex
import App from "./views/App.vue"; // Load App component

/**
 * Craft application
 */
new Vue({
    router,
    store,

    components: {App},
    el: '#app'
});
