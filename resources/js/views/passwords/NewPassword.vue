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
                try {
                    this.submitting = true;

                    let password = await this.$store.dispatch('passwords/create', Object.assign({}, model));

                    await this.$router.push({ path: '/passwords/' + password.id });

                    this.$swal({
                        toast: true,
                        title: 'Created Successfully',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        position: 'top'
                    });
                } catch (e) {
                    console.error(e);

                    this.$swal({
                        title: 'Something went wrong',
                        text: e?.data?.data?.message ?? 'Changes could not be saved.',
                        type: 'error',
                    });
                } finally {
                    this.submitting = false;
                }
            },
        },
    };
</script>
