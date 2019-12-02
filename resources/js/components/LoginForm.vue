<template>
    <form @submit.prevent="doLogin">
        <p>
            Please log in to view this page:
        </p>

        <div class="form-group">
            <label for="login-email">E-Mail Address</label>
            <input class="form-control" id="login-email" type="email" v-model="form_email">
        </div>
        <div class="form-group">
            <label for="login-password">Password</label>
            <input class="form-control" id="login-password" type="password" v-model="form_password">
        </div>

        <button class="btn btn-primary" type="submit">Login</button>
    </form>
</template>

<script>

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
                    let userToken = await this.$store.dispatch('auth/login',
                        {
                            email: this.form_email,
                            password: this.form_password
                        });

                    if (userToken === null)
                        this.$swal({
                            title: "Error",
                            text: "Please check your login credentials.",
                            type: "error"
                        });
                    else
                        this.$swal({
                            toast: true,
                            text: "Welcome back!",
                            timer: 3000,
                            type: "success",
                            showConfirmButton: false,
                            position: "top"
                        });
                } catch (err) {
                    console.error("Error while performing login:", err);

                    this.$swal({
                        title: "Error",
                        text: "An error occurred while logging you in.",
                        type: "error"
                    });
                }
            }
        }
    }
</script>
