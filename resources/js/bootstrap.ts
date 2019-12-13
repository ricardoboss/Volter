import Vue from "vue"
import Octicon from "vue-octicon/components/Octicon.vue"
import axios from "axios"
import VueAxios from "vue-axios";
import VueSweetalert2 from "vue-sweetalert2";
import BootstrapVue from "bootstrap-vue";
/**
 * Octicon icons
 */
import "vue-octicon/icons"

Vue.component('octicon', Octicon);

/**
 * Initialize axios to use the CSRF token from Laravel
 */
// set default header
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// get token from HTML meta element
let token: HTMLMetaElement | null = document.head.querySelector('meta[name="csrf-token"]');

// set token in default headers
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// use vue axios plugin
Vue.use(VueAxios, axios);

/**
 * Initialize Sweetalert
 */
Vue.use(VueSweetalert2);

/**
 * Initialize BootstrapVue
 */
Vue.use(BootstrapVue);

// helpers
Vue.prototype.$pick = function (obj: { [key: string]: any }, keys: any[]): Object {
    return Object.keys(obj)
        .filter(k => keys.includes(k))
        .map(k => Object.assign({}, {[k]: obj[k]}))
        .reduce((res, o) => Object.assign(res, o), {})
};
