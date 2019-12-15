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

                        if (this.$route.query.continue_with !== undefined) // redirect to intended route (if given)
                            await this.$router.replace({path: this.$route.query.continue_with});
                        else if (this.$route.meta.requiresGuest) // or to home route if the current one requires guest
                            await this.$router.push(homeRoute);
                    }
                } catch (err) {
                    this.$emit('login-fail', err);
                }
            }
        }
    }
</script>
