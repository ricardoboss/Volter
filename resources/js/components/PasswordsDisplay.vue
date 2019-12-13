<template>
    <div v-if="fields.length === 0">
        No fields selected.
    </div>
    <div v-else-if="type === 'table'" class="table-responsive">
        <b-table :items="table_data" :fields="table_fields" primary-key="id"/>
    </div>
    <div v-else-if="type === 'list'">
        <ul>
            <li v-for="password in passwords">
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

        computed: {
            table_data() {
                return this.passwords.map(password => {
                    return this.$pick(password, this.fields);
                });
            },

            table_fields() {
                return [
                    {key: 'id', sortable: true, isRowHeader: true},
                    {key: 'version', sortable: true},
                    {key: 'name', sortable: true},
                    {key: 'notes', sortable: true},
                    {key: 'value', sortable: true},
                    {key: 'created_at', sortable: true},
                    {key: 'created_by', sortable: true},
                    {key: 'updated_at', sortable: true},
                    {key: 'updated_by', sortable: true},
                    {key: 'deleted_at', sortable: true},
                    {key: 'deleted_by', sortable: true},
                ].filter(col => this.fields.includes(col.key));
            },
        }
    }
</script>
