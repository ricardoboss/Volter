<template>
    <form>
        <div class="form-group">
            <label for="login_modal_email">E-Mail Address</label>
            <input class="form-control" id="login_modal_email" type="email" v-model="form_email">
        </div>
        <div class="form-group">
            <label for="login_modal_password">E-Mail Address</label>
            <input class="form-control" id="login_modal_password" type="password" v-model="form_password">
        </div>

        <button @click.prevent="doLogin" class="btn btn-primary" type="submit">Login</button>
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
            doLogin() {
                this.$store.dispatch('auth/login',
                    {
                        email: this.form_email,
                        password: this.form_password
                    })
                    .then(() => this.$swal({
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        text: "You are now logged in.",
                        type: "success",
                        timer: 2000,
                        onRender: () => {
                            this.$router.push({name: 'home'});
                        }
                    }))
                    .catch(err => {
                        console.error("Error while performing login:", err);

                        this.$swal({
                            title: "Error",
                            text: "An error occurred while logging you in.",
                            type: "error"
                        });
                    })
            }
        }
    }
</script>
