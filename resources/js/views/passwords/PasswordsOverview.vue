<template>
    <passwords-display :passwords="this.all"
                       :fields="['created_by', 'id', 'version', 'updated_at', 'updated_by', 'actions']"/>
</template>

<script>
    import {mapGetters} from 'vuex';
    import PasswordsDisplay from '../../components/PasswordsDisplay';

    export default {
        components: { PasswordsDisplay },

        async created() {
            if (this.all.length === 0) await this.loadMore();
        },

        methods: {
            async loadMore() {
                await this.$store.dispatch('passwords/fetchNextPage');
            },
        },

        computed: {
            ...mapGetters('passwords', ['all']),
        },
    };
</script>
