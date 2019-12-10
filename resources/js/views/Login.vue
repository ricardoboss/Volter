<template>
    <div id="wrapper">
        <div id="inner-wrapper">
            <h1 class="display-1 text-center mb-4">Volter</h1>

            <div class="card shadow-lg mx-auto" id="login-form-container">
                <div class="card-body">
                    <login-form v-on:login-success="onLogin"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoginForm from "../components/LoginForm";
    import {homeRoute} from "../router";

    export default {
        name: "Login",
        components: {LoginForm},
        methods: {
            async onLogin() {
                await this.$router.push(homeRoute);
            }
        }
    }
</script>

<style>
    #wrapper {
        position: relative;
        height: 100%;
    }

    #inner-wrapper {
        position: relative;
        top: 50%;

        transform: translateY(-50%);
    }

    #login-form-container {
        max-width: 400px;
    }
</style>
