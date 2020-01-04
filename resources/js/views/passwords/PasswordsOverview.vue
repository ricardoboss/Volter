<template>
    <div>
        <b-button-group class="mb-3">
            <b-button @click="refresh" variant="outline-info">Refresh <v-icon scale="0.75" name="sync-alt"/></b-button>
            <b-button :to="{ path: '/passwords/new' }" variant="outline-primary"
                >Add <v-icon scale="0.75" name="plus"
            /></b-button>
        </b-button-group>

        <passwords-display ref="display" :fields="['created_by', 'name', 'updated_at', 'updated_by', 'actions']" />
    </div>
</template>

<script>
    import PasswordsDisplay from '../../components/PasswordsDisplay';

    export default {
        components: { PasswordsDisplay },

        methods: {
            refresh() {
                this.$refs.display.refresh();
            },
        },
    };
</script>
