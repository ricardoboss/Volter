<template>
    <div v-if="fields.length === 0">
        No fields selected.
    </div>
    <b-table-simple v-else-if="type === 'table'" hover sticky-header="100%">
        <b-thead>
            <b-tr>
                <b-th v-show="fields.includes('id')">ID</b-th>
                <b-th v-show="fields.includes('version')">Version</b-th>
                <b-th v-show="fields.includes('name')">Name</b-th>
                <b-th v-show="fields.includes('notes')">Notes</b-th>
                <b-th v-show="fields.includes('value')">Value</b-th>
                <b-th colspan="2" v-show="fields.includes('created_at') || fields.includes('created_by')">Created</b-th>
                <b-th colspan="2" v-show="fields.includes('updated_at') || fields.includes('updated_by')">Updated</b-th>
                <b-th colspan="2" v-show="fields.includes('deleted_at') || fields.includes('deleted_by')">Deleted</b-th>
            </b-tr>
        </b-thead>
        <b-tbody>
            <b-tr v-for="password in passwords" v-bind:key="password.id">
                <b-th v-show="fields.includes('id')">{{ password.id }}</b-th>
                <b-td v-show="fields.includes('version')">{{ password.version }}</b-td>
                <b-td v-show="fields.includes('name')">{{ password.name }}</b-td>
                <b-td v-show="fields.includes('notes')">{{ password.notes }}</b-td>
                <b-td v-show="fields.includes('value')">{{ password.value }}</b-td>

                <template v-if="fields.includes('created_at') && fields.includes('created_by')">
                    <b-td>{{ password.created_at }}</b-td>
                    <b-td>{{ password.created_by.name }}</b-td>
                </template>
                <b-td v-else-if="fields.includes('created_at')">{{ password.created_at }}</b-td>
                <b-td v-else-if="fields.includes('created_by')">{{ password.created_by.name }}</b-td>

                <template v-if="fields.includes('updated_at') && fields.includes('updated_by')">
                    <b-td>{{ password.updated_at }}</b-td>
                    <b-td>{{ password.updated_by.name }}</b-td>
                </template>
                <b-td v-else-if="fields.includes('updated_at')">{{ password.updated_at }}</b-td>
                <b-td v-else-if="fields.includes('updated_by')">{{ password.updated_by.name }}</b-td>

                <template v-if="fields.includes('deleted_at') && fields.includes('deleted_by')">
                    <b-td>{{ password.deleted_at }}</b-td>
                    <b-td>{{ password.deleted_by.name }}</b-td>
                </template>
                <b-td v-else-if="fields.includes('deleted_at')">{{ password.deleted_at }}</b-td>
                <b-td v-else-if="fields.includes('deleted_by')">{{ password.deleted_by.name }}</b-td>
            </b-tr>
        </b-tbody>
    </b-table-simple>
    <div v-else-if="type === 'list'">
        <ul>
            <li v-for="password in passwords" v-bind:key="password.id">
                <code v-show="fields.includes('id')">{{ password.id }}</code><br>
                <div v-show="fields.includes('version')">Version: {{ password.version }}</div>
                <div v-show="fields.includes('name')">Name: {{ password.name }}</div>
                <div v-show="fields.includes('notes')">Notes: {{ password.notes }}</div>
                <div v-show="fields.includes('value')">Value: {{ password.value }}</div>
                <div v-show="fields.includes('created_at') || fields.includes('created_by')">

                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            passwords: Array,
            autoload_more: {
                type: Boolean,
                default: true,
            },
            type: {
                type: String,
                default: 'table',
                validator: (val) => ['table', 'list'].includes(val),
            },
            responsive: {
                type: Boolean,
                default: true,
            },
            fields: {
                type: Array,
                default: () => ['id', 'name', 'notes', 'value', 'created_at'],
                validator: (val) => val.every(field => [
                    'id',
                    'version',
                    'name',
                    'notes',
                    'value',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by',
                    'deleted_at',
                    'deleted_by',
                ].includes(field)),
            }
        },
    }
</script>
