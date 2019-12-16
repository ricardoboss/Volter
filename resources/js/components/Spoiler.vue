<template>
    <b-badge :variant="variant" @click="toggle" class="spoiler p-2">
        <span v-if="!shown">Click to reveal</span>
        <span v-else-if="shown && loading">Loading...</span>
        <span v-else-if="shown && !loading" v-text="value" />
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
            default: 'dark',
        },
    },

    data() {
        return {
            shown: false,
            loading: false,
            value: null,
        };
    },

    methods: {
        async toggle() {
            this.shown = !this.shown;

            this.$emit(this.shown ? 'revealed' : 'hidden');

            if (!this.shown) return;

            this.loading = true;

            // call the value provider
            this.value = await this.value_provider.call(null, this.context);

            this.loading = false;
        },
    },
};
</script>

<style>
.spoiler {
    cursor: pointer;
}
</style>
