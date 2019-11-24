<template>
    <div class="container">
        <h1>Bruder</h1>

        <nav>
            <ul>
                <li>
                    <router-link :to="{ name: 'top' }">Top</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'new' }">New</router-link>
                </li>
            </ul>
        </nav>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>

<style scoped>

</style>
