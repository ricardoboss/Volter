import axios from 'axios'
import 'bootstrap'
import Vue from 'vue'
/**
 * Octicons
 */
import Octicon from 'vue-octicon/components/Octicon.vue'
import 'vue-octicon/icons'

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

Vue.component('octicon', Octicon);

