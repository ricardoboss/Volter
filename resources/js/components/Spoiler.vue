<template>
    <b-badge :variant="shown_variant" @click="toggle" class="spoiler p-2">
        <span v-if="loading">Loading...</span>
        <span v-else-if="shown" v-text="value" />
        <span v-else>Click to reveal</span>
    </b-badge>
</template>

<script>
    export default {
        props: {
            context: {
                type: Object | String | Number | Array,
                default: undefined,
            },
            value_provider: {
                type: Function,
            },
            variant: {
                type: String,
                default: 'light',
            },
            loading_variant: {
                type: String,
                default: 'secondary',
            },
            revealed_variant: {
                type: String,
                default: 'light',
            },
            errored_variant: {
                type: String,
                default: 'danger',
            },
        },

        data() {
            return {
                shown: false,
                loading: false,
                errored: false,
                value: null,
            };
        },

        methods: {
            async toggle() {
                this.errored = false; // reset error state
                this.value = null; // reset value
                this.shown = !this.shown; // toggle shown state

                // check if toggled to hidden state
                if (!this.shown) {
                    this.$emit('hidden');

                    return;
                }

                // shown === true so we have to reveal the value
                this.loading = true;

                try {
                    // call the value provider
                    this.value = await this.value_provider.call(null, this.context);

                    this.$emit('revealed', this.value);
                } catch (e) {
                    this.errored = true;
                    this.shown = true;

                    if (
                        typeof e !== 'undefined' &&
                        e.hasOwnProperty('data') &&
                        e.data.hasOwnProperty('data') &&
                        e.data.data.hasOwnProperty('message')
                    )
                        this.value = e.data.data.message;
                    else {
                        this.value = 'Error getting value';
                        console.error(e);
                    }

                    this.$emit('errored', e);
                } finally {
                    this.loading = false;
                }
            },
        },

        computed: {
            shown_variant() {
                if (this.loading) return this.loading_variant;
                if (this.errored) return this.errored_variant;
                if (this.shown) return this.revealed_variant;
                return this.variant;
            },
        },
    };
</script>

<style>
    .spoiler {
        cursor: pointer;
    }
</style>
