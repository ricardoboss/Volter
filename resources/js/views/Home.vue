<template>
    <div>
        <h1 class="display-3 mb-4">Dashboard</h1>

        <h2 class="mb-3">Manage</h2>

        <b-card-group deck>
            <b-card align="center" bg-variant="primary" body-class="p-1">
                <b-card-text>
                    <router-link :to="{ name: 'passwords' }" class="btn btn-link text-light">
                        Manage Passwords
                    </router-link>
                </b-card-text>
            </b-card>
            <b-card align="center" bg-variant="warning" body-class="p-1">
                <a href="#" class="btn btn-link text-dark">Manage Users</a>
            </b-card>
        </b-card-group>
    </div>
</template>
