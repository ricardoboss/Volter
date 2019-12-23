import axios from "axios";
import store from "./store";
import swal from "sweetalert2";
import router, {loginRoute} from "./router";

/**
 * == /!\ ======================================================================= /!\ ==
 *
 * Only added for debugging environments. Do not attach this interceptor in production!
 *
 * Simulates random request loading delays and random request fails.
 *
 * == /!\ ======================================================================= /!\ ==
 */
if (process.env.NODE_ENV !== 'production' && process.env.NODE_ENV !== 'testing') {
    console.warn('Attaching random API scrambler interceptor. (env: ' + process.env.NODE_ENV + ')');

    axios.interceptors.request.use(async config => {
        await new Promise(resolve => setTimeout(resolve, 50 + Math.random() * 1000));

        if (Math.random() < 0.05) throw 'Random debug API request rejection.';

        return config;
    });
}

/**
 * Interceptors for telling Vuex when the api is loading.
 */
axios.interceptors.request.use(async config => {
    await store.dispatch('api/setLoading', true);

    return config;
});

axios.interceptors.response.use(
    async response => {
        await store.dispatch('api/setLoading', false);

        return response;
    },
    async error => {
        await store.dispatch('api/setLoading', false);

        throw error;
    }
);

/**
 * Interceptor for logging the user out if we receive a 401 response.
 * A 401 status indicates that our jwt is expired.
 */
axios.interceptors.response.use(
    async response => await response,
    async error => {
        if (error.response.status === 401 && store.getters['auth/isAuthenticated']) {
            console.warn("Got HTTP status 401. Logging out.");

            await store.dispatch('auth/logout', {invalidate: false});
            await router.push(loginRoute);
            await swal.fire(
                'Session expired',
                'You have been logged out due to your session being expired.',
                'warning'
            );
        }

        throw error;
    }
);

/**
 * Interceptor for handling failed requests
 */
axios.interceptors.response.use(
    async response => await response,
    async error => {
        // flatten the error down to the response from the server
        throw error?.response ?? new Error("Unknown error.");
    }
);
