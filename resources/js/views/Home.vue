<template>
    <div>
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
                <tr v-for="password in passwords.fetched">
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
                </tbody>
            </table>
        </div>

        <div class="btn-group">
            <button @click.prevent="loadMore" class="btn btn-outline-secondary">Load more</button>
            <button @click="logout" class="btn btn-outline-danger">Logout</button>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        async created() {
            await this.loadMore();
        },

        methods: {
            logout() {
                this.$store.dispatch('auth/logout');

                this.$swal({
                    toast: true,
                    text: "Goodbye!",
                    timer: 3000,
                    type: "success",
                    showConfirmButton: false,
                    position: "top"
                });
            },

            async loadMore() {
                await this.$store.dispatch('passwords/fetchNextPage');
            },

            edit(password) {
                // TODO: show edit modal
            }
        },

        computed: {
            ...mapState(['passwords'])
        }
    }
</script>

<style scoped>

</style>
