<template>
    <div>
        <h1>Passwords</h1>

        <passwords-display :passwords="this.all"/>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";
    import PasswordsDisplay from "../components/PasswordsDisplay";

    export default {
        components: {PasswordsDisplay},

        async created() {
            await this.loadMore();
        },

        methods: {
            async loadMore() {
                await this.$store.dispatch('passwords/fetchNextPage');
            },
        },

        computed: {
            ...mapGetters('passwords', ['all'])
        }
    }
</script>

<style scoped>

</style>
