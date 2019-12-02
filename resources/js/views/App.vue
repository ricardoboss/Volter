<template>
    <div :class="['vh-100']">
        <main class="container pt-3">
            <loading-overlay v-if="api.loading"/>
            <login-form v-else-if="!isAuthenticated"/>
            <router-view v-else/>
        </main>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import LoginForm from "../components/LoginForm";
    import axios from "axios";
    import LoadingOverlay from "../components/LoadingOverlay";

    export default {
        components: {LoadingOverlay, LoginForm},

        async created() {
            // TODO: move axios interceptors to a more appropriate place (only here for access to this.$store)
            this.setupAxiosInterceptors();

            if (!this.isAuthenticated) {
                try {
                    // attempt to log in from a stored token
                    await this.$store.dispatch('auth/loginFromStorage');
                } catch (e) {
                    console.warn("Error while logging in via storage: " + e);
                }
            }
        },

        methods: {
            setupAxiosInterceptors() {
                // for simulating api loading delay
                function sleep(ms) {
                    return new Promise(resolve => setTimeout(resolve, ms))
                }

                axios.interceptors.request.use(async config => {
                    await this.$store.dispatch('api/setLoading', true);

                    // TODO: remove in production; simulates API loading and errors
                    await sleep(Math.random() * 1000);
                    if (Math.random() < 0.1)
                        return Promise.reject("API mock rejection (no real error)");

                    return config;
                });

                axios.interceptors.response.use(async response => {
                    await this.$store.dispatch('api/setLoading', false);

                    return response;
                }, async error => {
                    await this.$store.dispatch('api/setLoading', false);

                    return Promise.reject(error);
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
