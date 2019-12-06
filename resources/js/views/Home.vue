<template>
    <div>
        <ul class="list-group" v-for="password in passwords">
            <li class="list-group-item">
                <strong>{{ password.name }}</strong>
                <pre>{{ password.value }}</pre>
                <textarea>{{ password.notes }}</textarea>
            </li>
        </ul>

        <button @click="logout" class="btn btn-outline-danger">Logout</button>
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
        async created() {
            await this.$store.dispatch('passwords/fetch', {
                count: 10,
            });
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
            }
        },

        computed: {
            ...mapState(['auth', 'passwords']),
        }
    }
</script>

<style scoped>

</style>
