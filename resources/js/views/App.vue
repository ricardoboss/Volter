<template>
    <div :class="[bodyBgTheme, bodyTextTheme, 'vh-100']">
        <nav :class="['navbar', 'navbar-expand-lg', navbarTheme, navbarBgTheme]">
            <div class="container-lg">
                <button class="navbar-toggler" data-target="#navbarTogglerMain"
                        data-toggle="collapse"
                        type="button">
                    <span class="navbar-toggler-icon"></span>
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
                </div>
            </div>
        </nav>

        <main class="container pt-3">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    import * as $ from "jquery";
    import {mapGetters} from "vuex";

    export default {
        name: "App",

        computed: {
            ...mapGetters({
                theme: 'getTheme'
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

            bodyTextTheme() {
                switch (this.theme) {
                    case 'light':
                        return 'text-body';
                    case 'dark':
                        return 'text-white';
                }

                return 'text-' + this.theme;
            },

            bodyBgTheme() {
                switch (this.theme) {
                    case 'light':
                        return 'bg-transparent';
                    case 'dark':
                        return 'bg-dark';
                }

                return 'bg-' + this.theme;
            }
        },

        watch: {
            '$route'() {
                $('#navbarTogglerMain').collapse('hide');
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>
