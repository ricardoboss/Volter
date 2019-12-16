<template>
    <div class="container-fluid" id="wrapper">
        <h1 class="display-1 text-center mb-4">Volter</h1>

        <div class="card shadow-lg mx-auto" id="login-form-container">
            <div class="card-body">
                <login-form v-on:login-success="onLoginSuccess" v-on:login-fail="onLoginFail" />
            </div>
        </div>
    </div>
</template>

<script>
import LoginForm from '../components/LoginForm';

export default {
    components: { LoginForm },

    methods: {
        onLoginSuccess() {
            this.$swal({
                toast: true,
                text: 'Welcome back!',
                type: 'success',
                timer: 3000,
                showConfirmButton: false,
                position: 'top',
            });
        },

        onLoginFail(error) {
            this.$swal({
                title: 'Login failed',
                text: error ?? 'Please check your login credentials.',
                type: 'error',
            });
        },
    },
};
</script>

<style scoped>
#wrapper {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translateY(-50%) translateX(-50%);
}

#login-form-container {
    max-width: 300px;
}
</style>
