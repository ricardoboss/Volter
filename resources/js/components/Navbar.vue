<template>
    <nav :class="['navbar', 'navbar-expand-lg', navbarTheme, navbarBgTheme]">
        <div class="container-lg">
            <button class="navbar-toggler" data-target="#navbarTogglerMain"
                    data-toggle="collapse"
                    type="button">
                <span class="navbar-toggler-icon"/>
            </button>
            <router-link :to="{ name: 'home' }" class="navbar-brand">Volter</router-link>

            <div class="collapse navbar-collapse" id="navbarTogglerMain">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <router-link :to="{ name: 'home' }" class="nav-link">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'settings' }" class="nav-link">Settings</router-link>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item" v-if="isAuthenticated">
                        <a @click.prevent="doLogout" style="cursor: pointer">Logout</a>
                    </li>
                    <li class="nav-item" v-else>
                        <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import {mapGetters} from "vuex";
    import * as $ from "jquery";

    export default {
        methods: {
            doLogout() {
                this.$store.dispatch('auth/logout')
                    .then(() => this.$swal({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        text: "Logged out.",
                        type: "success",
                        timer: 2000,
                        onRender: () => {
                            this.$router.push({name: 'login'});
                        }
                    }))
                    .catch(err => {
                        console.error("Error while performing logout:", err);

                        this.$swal({
                            title: "Error",
                            text: "An error occurred while logging you out.",
                            type: "error"
                        });
                    })
            }
        },

        computed: {
            ...mapGetters('settings', {
                theme: 'getTheme'
            }),
            ...mapGetters('auth', {
                isAuthenticated: 'isAuthenticated'
            }),

            navbarTheme() {
                return 'navbar-' + this.theme;
            },

            navbarBgTheme() {
                switch (this.theme) {
                    case 'light':
                        return 'bg-light';
                    case 'dark':
                        return 'bg-secondary';
                }

                return 'bg-' + this.theme;
            },
        },

        watch: {
            '$route'() {
                $('#navbarTogglerMain').collapse('hide');
            }
        }
    }
</script>

<style scoped>

</style>
