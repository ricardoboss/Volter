<template>
    <div class="container">
        <h1>Settings</h1>

        <button @click="setDarkTheme" class="btn btn-outline-secondary">Dark</button>
        <button @click="setLightTheme" class="btn btn-outline-secondary">Light</button>
    </div>
</template>

<script>
    export default {
        name: "Settings",

        methods: {
            setDarkTheme() {
                this.$store.dispatch('settings/setDarkTheme');
            },

            setLightTheme() {
                this.$store.dispatch('settings/setLightTheme');
            }
        }
    }
</script>

<style scoped>

</style>
