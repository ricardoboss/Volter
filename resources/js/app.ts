/**
 * SCSS styles
 */
import "../sass/app.scss"
/**
 * Load all Javascript utilities and other dependencies.
 */
import "./bootstrap.ts"
/**
 * Load VueJS and all the components
 */
import Vue from "vue"
import "./components/index.ts"
/**
 * Load VueRouter and Vuex
 */
import router from "./router"
import store from "./store"
/**
 * Load App component
 */
import App from "./views/App.vue";

/**
 * Craft application
 */
new Vue({
    router,
    store,

    components: {App},
    el: '#app'
});
