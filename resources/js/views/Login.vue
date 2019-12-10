<template>
    <div>
        <login-form v-on:login-success="loggedIn"/>
    </div>
</template>

<script>
    import LoginForm from "../components/LoginForm";

    export default {
        name: "Login",
        components: {LoginForm},
        methods: {
            async loggedIn() {
                await this.$router.push({name: 'home'});
            }
        }
    }
</script>
