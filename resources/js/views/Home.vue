<template>
    <div>
        <passwords-display :passwords="this.all"
                           :fields="[
                    'id',
                    'version',
                    'name',
                    'notes',
                    'value',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by',
                    'deleted_at',
                    'deleted_by',
                ]"/>
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
