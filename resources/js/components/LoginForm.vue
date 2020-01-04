<template>
    <form @submit.prevent="doLogin">
        <div class="form-group">
            <label for="login-email">E-Mail Address</label>
            <input
                class="form-control"
                id="login-email"
                type="email"
                autofocus
                autocomplete="username"
                v-model="form_email"
                required
                tabindex="1"
            />
        </div>
        <div class="form-group">
            <label for="login-password">Password</label>
            <input
                class="form-control"
                id="login-password"
                type="password"
                autocomplete="current-password"
                v-model="form_password"
                required
                tabindex="2"
            />
        </div>

        <button class="btn btn-primary float-right" type="submit" tabindex="3">
            Login
        </button>
    </form>
</template>

<script>
    import { homeRoute } from '../router';

    export default {
        props: {
            email: {
                type: String,
                default: '',
            },
            password: {
                type: String,
                default: '',
            },
        },

        data() {
            return {
                form_email: this.email,
                form_password: this.password,
            };
        },

        methods: {
            async doLogin() {
                try {
                    this.$emit('login-pending');

                    let userToken = await this.$store.dispatch('auth/login', {
                        email: this.form_email,
                        password: this.form_password,
                    });

                    if (userToken === null) {
                        this.$emit('login-fail', null);
                    } else {
                        this.$emit('login-success');

                        await this.$router.continue(homeRoute);
                    }
                } catch (e) {
                    this.$emit('login-fail', e);
                }
            },
        },
    };
</script>
