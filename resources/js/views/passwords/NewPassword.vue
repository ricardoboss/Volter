<template>
    <div>
        <router-link :to="{ path: '/passwords' }">&laquo; back to overview</router-link>

        <div v-if="submitting" class="d-block">
            <b-spinner class="mx-auto d-block" variant="primary" />
        </div>

        <password-form v-else @submit="submitModel" />
    </div>
</template>

<script>
    import PasswordForm from '../../components/PasswordForm';
    export default {
        components: { PasswordForm },

        data() {
            return {
                submitting: false,
            };
        },

        methods: {
            async submitModel(model) {
                this.submitting = true;

                let password = await this.$store.dispatch('passwords/create', Object.assign({}, model));

                await this.$swal({
                    title: 'Successfully created',
                    text: 'Your password was saved!',
                    type: 'success',
                });

                this.submitting = false;

                await this.$router.push({ path: '/passwords/' + password.id });
            },
        },
    };
</script>
