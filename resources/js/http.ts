import axios from "axios";
import store from "./store";

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
 * Interceptor for handling failed requests
 */
axios.interceptors.response.use(
    async response => response,
    async error => {
        // flatten the error down to the response from the server
        throw error.response;
    }
);
