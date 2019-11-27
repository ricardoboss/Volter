<template>
    <div class="container">
        <h1>Settings</h1>

        <button @click="setDarkTheme" class="btn btn-outline-secondary">Dark</button>
        <button @click="setLightTheme" class="btn btn-outline-secondary">Light</button>
    </div>
</template>

<script>
    import {mapActions} from "vuex";

    export default {
        name: "Settings",

        methods: {
            ...mapActions([
                'setDarkTheme',
                'setLightTheme'
            ])
        }
    }
</script>

<style scoped>

</style>
