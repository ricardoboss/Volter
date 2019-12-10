<template>
    <div :class="['vh-100']">
        <main class="container pt-3">
            <loading-overlay v-if="api.loading"/>

            <router-view/>
        </main>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";
    import LoadingOverlay from "../components/LoadingOverlay";

    export default {
        components: {LoadingOverlay},

        async created() {
            this.setupAxiosInterceptors();

            if (!this.isAuthenticated) {
                try {
                    // attempt to log in from a stored token
                    await this.$store.dispatch('auth/loginFromStorage');
                } catch (e) {
                    console.log("Error while logging in via storage: ", e);
                }
            }
        },

        methods: {
            setupAxiosInterceptors() {
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
                    console.warn("Attaching random API scrambler interceptor.");

                    axios.interceptors.request.use(async config => {
                        await new Promise(resolve => setTimeout(resolve, 100 + Math.random() * 1900));

                        if (Math.random() < 0.1)
                            throw "Random debug API request rejection.";

                        return config;
                    });
                }

                // TODO: move axios interceptors to a more appropriate place (only here for access to this.$store)
                axios.interceptors.request.use(async config => {
                    await this.$store.dispatch('api/setLoading', true);

                    return config;
                });

                axios.interceptors.response.use(async response => {
                    await this.$store.dispatch('api/setLoading', false);

                    return response;
                }, async error => {
                    await this.$store.dispatch('api/setLoading', false);

                    throw error;
                });
            }
        },

        computed: {
            ...mapState(['api']),

            ...mapGetters('auth', [
                'isAuthenticated',
            ])
        }
    }
</script>
