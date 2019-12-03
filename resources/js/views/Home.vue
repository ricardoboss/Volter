<template>
    <div>
        <h1>Home</h1>

        <p>
            {{ auth.user.name }}
        </p>

        <button @click="logout" class="btn btn-outline-danger">Logout</button>
    </div>
</template>

<script>
    import {mapState} from "vuex";

    export default {
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
            ...mapState(['auth'])
        }
    }
</script>

<style scoped>

</style>
