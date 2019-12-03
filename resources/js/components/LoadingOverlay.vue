<template>
    <div id="loader">
        <div class="spinner-border text-primary"></div>
    </div>
</template>

<style lang="scss" scoped>
    #loader {
        display: flex;
        flex-flow: column;
        justify-content: center;
        align-items: center;

        background-color: rgba(255, 255, 255, 0.75);

        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 1000;
        user-select: none;
    }
</style>
