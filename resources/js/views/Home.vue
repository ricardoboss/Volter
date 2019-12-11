<template>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Value</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="password in this.all">
                <td>
                    <pre>{{ password.id }}</pre>
                </td>
                <td>{{ password.name }}</td>
                <td>{{ password.value }}</td>
                <td>
                    <div class="btn-group">
                        <button @click.prevent="edit(password)" class="btn btn-link">edit</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <b-spinner class="mx-auto" type="grow" v-b-visible="loadMore" variant="primary"/>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        async created() {
            await this.loadMore();
        },

        methods: {
            async loadMore() {
                await this.$store.dispatch('passwords/fetchNextPage');
            },

            edit(password) {
                // TODO: show edit modal
            }
        },

        computed: {
            ...mapGetters('passwords', ['all'])
        }
    }
</script>

<style scoped>

</style>
