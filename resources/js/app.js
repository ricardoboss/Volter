/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Walk over every property of an object recursively.
 *
 * @param obj       The object to walk over.
 * @param callback  The callback to call when a non-object is found.
 * @param path      The path of keys to the current object.
 */
function recursiveWalkObj(obj, callback, path = "") {
    if (!(obj instanceof Object))
        callback(path.substr(0, path.length - 1), obj);
    else
        for (let k of Object.keys(obj))
            recursiveWalkObj(obj[k], callback, path + k + "-");
}

/**
 * Load the component map
 */
const componentMap = require('./components/map');
recursiveWalkObj(componentMap.components, (path, file) => {
    // register vue components dynamically
    Vue.component(path, file);
});

/**
 * Import views
 */
import App from "./views/App";
import Top from "./views/Top";
import New from "./views/New";
/**
 * Initialize VueRouter
 */
import VueRouter from "vue-router";

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/top',
            name: 'top',
            component: Top
        },
        {
            path: '/new',
            name: 'new',
            component: New,
        },
    ],
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {App},
    router,
});
