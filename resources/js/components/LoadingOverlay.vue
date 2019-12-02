<template>
    <div id="loader">
        <div class="spinner-border text-primary"></div>
    </div>
</template>

<script>
    export default {}
</script>

<style lang="scss" scoped>
    #loader {
        display: flex;
        flex-flow: column;
        justify-content: center;
        align-items: center;

        opacity: 0.8;

        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 1000;
    }
</style>
