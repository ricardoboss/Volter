<template>
    <div>
        <b-form class="my-4" v-if="!loading" @submit.prevent="submitModel" @reset="resetModel">
            <h2>Editing {{ model.name }}</h2>

            <b-form-group label="Name" label-for="name"
                          description="An easy to identify and unique name for this password.">
                <b-form-input id="name" v-model="model.name" type="text" required placeholder="Please enter a name"/>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="outline-danger">Reset</b-button>
        </b-form>

        <div v-else class="my-4 d-block">
            <b-spinner class="mx-auto d-block" type="grow" variant="primary"/>
        </div>

        <router-link :to="{ path: '/passwords' }">&laquo; back to overview</router-link>
    </div>
</template>

<script>
    import api from "../../api";
    import router from "../../router";

    export default {
        async mounted() {
            if (this.model !== null) {
                return;
            }

            console.log("Mounted without model. Fetching...");

            let password = await api.passwords.get(this.$route.params.id);

            await this.storeModel(password);
        },

        data() {
            return {
                model: null,
                original: null,
                submitting: false,
            };
        },

        methods: {
            async storeModel(model) {
                if (this.model !== null)
                    this.original = Object.assign({}, this.model);
                else
                    this.original = Object.assign({}, model);

                this.model = model;
            },

            async resetModel() {
                this.model = Object.assign({}, this.original);
            },

            async submitModel() {
                this.submitting = true;

                await api.passwords.edit(this.model);

                await this.$swal({
                    title: 'Successfully updated',
                    text: 'Changes were saved.',
                    type: 'success'
                });

                this.submitting = false;
            }
        },

        computed: {
            loading() {
                return this.model === null || this.submitting;
            }
        },

        async beforeRouteEnter(to, from, next) {
            try {
                let password = await api.passwords.get(router.currentRoute.params.id);

                await next(vm => vm.storeModel(password));
            } catch (e) {
                await next(async vm => {
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
    }
</script>

<style scoped>

</style>
