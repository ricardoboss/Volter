<template>
    <div class="vh-100 pt-5">
        <b-navbar class="shadow" fixed="top" toggleable="sm" type="light" variant="light">
            <b-navbar-brand target="nav-collapse">Volter</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse" />

            <b-collapse id="nav-collapse" is-nav>
                <template v-if="isAuthenticated">
                    <b-navbar-nav>
                        <b-nav-item :to="{ name: 'home' }">Home</b-nav-item>
                        <b-nav-item :to="{ name: 'passwords' }">Passwords</b-nav-item>
                    </b-navbar-nav>

                    <b-navbar-nav class="ml-auto">
                        <b-nav-item-dropdown right>
                            <template v-slot:button-content>
                                {{ auth.user.name }}
                            </template>

                            <b-dropdown-item href="#">Account</b-dropdown-item>
                            <b-dropdown-divider />
                            <b-dropdown-item @click.prevent="logout">Logout</b-dropdown-item>
                        </b-nav-item-dropdown>
                    </b-navbar-nav>
                </template>
                <template v-else>
                    <b-navbar-nav>
                        <b-nav-item :to="{ name: 'login' }">Login</b-nav-item>
                    </b-navbar-nav>
                </template>
            </b-collapse>
        </b-navbar>

        <main class="container mt-4">
            <loading-overlay v-if="this.api.loading" />

            <router-view />
        </main>
    </div>
</template>

<script>
    import { mapGetters, mapState } from 'vuex';
    import LoadingOverlay from '../components/LoadingOverlay';
    import { homeRoute, loginRoute } from '../router';

    export default {
        components: { LoadingOverlay },

        async created() {
            if (this.isAuthenticated) return;

            try {
                // attempt to log in from a stored token
                await this.$store.dispatch('auth/loginFromStorage');

                // check if authenticated now for redirection
                if (!this.isAuthenticated) return;

                await this.$router.continue(homeRoute);
            } catch (e) {
                console.log('Error while logging in via storage: ', e);
            }
        },

        methods: {
            async logout() {
                await this.$store.dispatch('auth/logout');
                await this.$router.push(loginRoute);
                await this.$swal({
                    toast: true,
                    text: 'Goodbye!',
                    timer: 3000,
                    type: 'success',
                    showConfirmButton: false,
                    position: 'top',
                });
            },
        },

        computed: {
            ...mapState(['api', 'auth']),

            ...mapGetters('auth', ['isAuthenticated']),
        },
    };
</script>
