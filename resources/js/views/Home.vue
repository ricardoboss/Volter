<template>
    <div>
        <h1>Volter</h1>

        <p class="lead">In-House Password Vault</p>

        <p v-if="isAuthenticated">
            Welcome, {{ this.user.name }}!
        </p>
    </div>
</template>

<script>
    import {mapGetters, mapState} from "vuex";

    export default {
        computed: {
            ...mapState('auth', [
                'user'
            ]),

            ...mapGetters('auth', {
                isAuthenticated: 'isAuthenticated'
            }),
        }
    }
</script>
