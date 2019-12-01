<template>
    <div :class="[bodyBgTheme, bodyTextTheme, 'vh-100']">
        <navbar/>

        <main class="container pt-3">
            <router-view/>
        </main>
    </div>
</template>

<script>
    import Navbar from "../components/Navbar";
    import {mapGetters} from "vuex";

    export default {
        components: {Navbar},

        mounted() {
            if (!this.$store.state['auth/isAuthenticated']) {
                // attempt to log in from a stored token
                this.$store.dispatch('auth/loginFromStorage');
                this.$router.replace({name: 'home'});
            }
        },

        computed: {
            ...mapGetters('settings', {
                theme: 'getTheme'
            }),

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
        }
    }
</script>
