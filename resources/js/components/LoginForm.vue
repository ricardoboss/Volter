<template>
    <form @submit.prevent="doLogin">
        <div class="form-group">
            <label for="login-email">E-Mail Address</label>
            <input class="form-control" id="login-email" type="email" autocomplete="username" v-model="form_email">
        </div>
        <div class="form-group">
            <label for="login-password">Password</label>
            <input class="form-control" id="login-password" type="password" autocomplete="current-password"
                   v-model="form_password">
        </div>

        <button class="btn btn-primary float-right" type="submit">Login</button>
    </form>
</template>

<script>
    import {homeRoute} from "../router";

    export default {
        props: {
            email: {
                type: String,
                default: ""
            },
            password: {
                type: String,
                default: ""
            }
        },

        data() {
            return {
                form_email: this.email,
                form_password: this.password,
            }
        },

        methods: {
            async doLogin() {
                try {
                    this.$emit('login-pending');

                    let userToken = await this.$store.dispatch('auth/login',
                        {
                            email: this.form_email,
                            password: this.form_password
                        });

                    if (userToken === null) {
                        this.$emit('login-fail', null);
                    } else {
                        this.$emit('login-success');

                        // default next route is home
                        let route = homeRoute;

                        // check if next route is specified
                        if (this.$route.query.continue_with !== null)
                            route = {path: this.$route.query.continue_with};

                        // replace login with next route
                        await this.$router.replace(route);
                    }
                } catch (err) {
                    this.$emit('login-fail', err);
                }
            }
        }
    }
</script>
