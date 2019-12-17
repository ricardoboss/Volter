<template>
    <div class="container" id="wrapper">
        <h1 class="display-1">404</h1>
        <h2 class="display-4 nobr">Not Found</h2>

        <p class="lead mt-5">
            The requested resource could not be found.
        </p>

        <ul class="mt-3">
            <li v-if="this.isAuthenticated">
                <span>Go</span>
                <router-link :to="{ name: 'home' }" replace>Home</router-link>
            </li>
            <li v-else>
                <span>Go to</span>
                <router-link :to="{ name: 'login' }" replace>Login</router-link>
            </li>
            <li><a href="javascript:history.back()">&laquo; Back to previous page</a></li>
        </ul>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        computed: {
            ...mapGetters('auth', ['isAuthenticated']),
        },
    };
</script>

<style scoped>
    #wrapper {
        position: fixed;
        top: 30%;
        left: 50%;
        transform: translateY(-30%) translateX(-50%);
    }
</style>
