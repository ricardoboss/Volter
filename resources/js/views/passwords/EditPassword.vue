<template>
    <div>
        <router-link :to="{ path: '/passwords' }">&laquo; back to overview</router-link>

        <div v-if="loading" class="d-block">
            <b-spinner class="mx-auto d-block" variant="primary" />
        </div>

        <password-form :editable="model.editable" @submit="submit" v-else v-model="model" />
    </div>
</template>

<script>
    import api from '../../api';
    import PasswordForm from '../../components/PasswordForm';

    export default {
        components: { PasswordForm },

        data() {
            return {
                model: null,
                submitting: false,
            };
        },

        methods: {
            async submit(password) {
                try {
                    this.submitting = true;

                    await this.$store.dispatch('passwords/update', { password });

                    this.model = password;

                    await this.$router.push({ path: '/passwords' });

                    this.$swal({
                        toast: true,
                        title: 'Successfully Saved',
                        text: 'Changes were saved successfully.',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        position: 'top',
                    });
                } catch (e) {
                    this.$swal({
                        title: 'Request Failed',
                        text: e?.data?.data?.message ?? 'Changes could not be saved.',
                        type: 'error',
                    });
                } finally {
                    this.submitting = false;
                }
            },
        },

        computed: {
            loading() {
                return this.model === null || this.submitting;
            },
        },

        async beforeRouteEnter(to, from, next) {
            try {
                next(async vm => {
                    let id = vm.$route.params.id;
                    vm.model = await api.passwords.get(id);
                });
            } catch (e) {
                next(async vm => {
                    await vm.$swal({
                        title: 'Unable to get password',
                        text: e?.data?.data?.message ?? 'Unknown error.',
                        type: 'error',
                    });

                    return to;
                });
            }
        },

        async beforeRouteUpdate(to, from, next) {
            this.model = null;

            try {
                this.model = await api.passwords.get(this.$route.params.id);

                next();
            } catch (e) {
                await next(from);

                await this.$swal({
                    title: 'Unable to get password',
                    text: e?.data?.data?.message ?? 'Unknown error.',
                    type: 'error',
                });
            }
        },
    };
</script>
