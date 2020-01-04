import Vue from "vue"
import axios from "axios"
import VueAxios from "vue-axios";
import VueSweetalert2 from "vue-sweetalert2";
import BootstrapVue from "bootstrap-vue";
import Icon from "vue-awesome/components/Icon.vue";
import "./icons";
import "./http";

/**
 * Use vue axios plugin
 */
Vue.use(VueAxios, axios);

/**
 * Initialize axios to use the CSRF token from Laravel
 */
// set default header
Vue.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// get token from HTML meta element
let token: HTMLMetaElement | null = document.head.querySelector('meta[name="csrf-token"]');

// set token in default headers
if (token) {
    Vue.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Initialize Sweetalert
 */
Vue.use(VueSweetalert2);

/**
 * Initialize BootstrapVue
 */
Vue.use(BootstrapVue);

/**
 * Add the icon component
 */
Vue.component('v-icon', Icon);
