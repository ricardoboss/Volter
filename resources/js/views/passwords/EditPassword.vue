<template>
    <div>
        <password-form v-if="model != null" v-model="model" @submit="submitModel"/>

        <div v-else class="d-block">
            <b-spinner class="mx-auto d-block" variant="primary"/>
        </div>

        <router-link :to="{ path: '/passwords' }">&laquo; back to overview</router-link>
    </div>
</template>

<script>
    import api from '../../api';
    import PasswordForm from "../../components/PasswordForm";

    export default {
        components: {PasswordForm},

        data() {
            return {
                model: null,
                original: null,
                submitting: false,
            };
        },

        methods: {
            async submitModel(model) {
                this.submitting = true;

                await api.passwords.edit(model);

                this.storeModel(model);

                await this.$swal({
                    title: 'Successfully updated',
                    text: 'Changes were saved.',
                    type: 'success',
                });

                this.submitting = false;
            },

            storeModel(model) {
                if (this.model !== null) this.original = Object.assign({}, this.model);
                else this.original = Object.assign({}, model);

                this.model = model;
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
                    let password = await api.passwords.get(id);

                    vm.storeModel(password);
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
                let password = await api.passwords.get(this.$route.params.id);

                this.storeModel(password);

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
