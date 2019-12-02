<template>
    <div :class="['vh-100']">
        <main class="container pt-3">
            <login-form v-if="!isAuthenticated && !api.loading"/>
            <div class="vh-100 vw-100 d-flex flex-column justify-content-center align-items-center"
                 v-else-if="api.loading">
                <p>
                    Loading...
                </p>
                <div class="spinner-border"></div>
            </div>
            <router-view v-else/>
        </main>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import LoginForm from "../components/LoginForm";
    import axios from "axios";

    export default {
        components: {LoginForm},

        async created() {
            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms))
            }

            // TODO: move axios interceptors to a more appropriate place (only here for access to this.$store)
            axios.interceptors.request.use(async config => {
                await this.$store.dispatch('api/setLoading', true);

                await sleep(500);

                return config;
            });

            axios.interceptors.response.use(async response => {
                await this.$store.dispatch('api/setLoading', false);

                return response;
            }, async error => {
                await this.$store.dispatch('api/setLoading', false);

                return Promise.reject(error);
            });

            if (!this.isAuthenticated) {
                try {
                    // attempt to log in from a stored token
                    await this.$store.dispatch('auth/loginFromStorage');
                } catch (e) {
                    console.log("Error while mounting app: " + e);
                }
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
