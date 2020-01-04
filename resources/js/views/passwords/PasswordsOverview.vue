<template>
    <div>
        <b-button-toolbar class="mb-3">
            <b-button :to="{ path: '/passwords/new' }" variant="outline-primary">Add <v-icon scale="0.75" name="plus" /></b-button>
        </b-button-toolbar>

        <passwords-display v-show="this.all.length > 0"
                           :passwords="this.all"
                           :fields="['created_by', 'name', 'updated_at', 'updated_by', 'actions']" />

        <b-alert :show="this.all.length === 0" variant="info">
            No passwords found. Add one by clicking on the "Add <v-icon scale="0.75" name="plus" />" button above.
        </b-alert>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
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
