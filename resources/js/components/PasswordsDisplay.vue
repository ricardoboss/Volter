<template>
    <div v-if="fields.length === 0">
        No fields selected.
    </div>

    <b-table-simple v-else-if="type === 'table'" bordered hover :responsive="responsive" :sticky-header="max_height">
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
                <b-th v-show="fields.includes('id')" class="nobr"><code>{{ password.id }}</code></b-th>
                <b-td v-show="fields.includes('version')">{{ password.version }}</b-td>
                <b-td v-show="fields.includes('name')" class="nobr">{{ password.name }}</b-td>
                <b-td v-show="fields.includes('notes')">{{ password.notes }}</b-td>
                <b-td v-show="fields.includes('value')">{{ password.value }}</b-td>

                <template v-if="fields.includes('created_at') && fields.includes('created_by')">
                    <b-td class="nobr">{{ password.created_at }}</b-td>
                    <b-td class="nobr">{{ password.created_by !== null ? password.created_by.name : '' }}</b-td>
                </template>
                <b-td colspan="2" v-else-if="fields.includes('created_at')" class="nobr">{{ password.created_at }}
                </b-td>
                <b-td colspan="2" v-else-if="fields.includes('created_by')" class="nobr">{{ password.created_by !== null
                    ?
                    password.created_by.name : '' }}
                </b-td>

                <template v-if="fields.includes('updated_at') && fields.includes('updated_by')">
                    <b-td class="nobr">{{ password.updated_at }}</b-td>
                    <b-td class="nobr">{{ password.updated_by !== null ? password.updated_by.name : '' }}</b-td>
                </template>
                <b-td colspan="2" v-else-if="fields.includes('updated_at')" class="nobr">{{ password.updated_at }}
                </b-td>
                <b-td colspan="2" v-else-if="fields.includes('updated_by')" class="nobr">{{ password.updated_by !== null
                    ?
                    password.updated_by.name : '' }}
                </b-td>

                <template v-if="fields.includes('deleted_at') && fields.includes('deleted_by')">
                    <b-td class="nobr">{{ password.deleted_at }}</b-td>
                    <b-td class="nobr">{{ password.deleted_by !== null ? password.deleted_by.name : '' }}</b-td>
                </template>
                <b-td colspan="2" v-else-if="fields.includes('deleted_at')" class="nobr">{{ password.deleted_at }}
                </b-td>
                <b-td colspan="2" v-else-if="fields.includes('deleted_by')" class="nobr">{{ password.deleted_by !== null
                    ?
                    password.deleted_by.name : '' }}
                </b-td>
            </b-tr>
        </b-tbody>
    </b-table-simple>

    <div v-else-if="type === 'list'" :class="max_height !== null ? 'border' : ''"
         :style="'overflow-y: auto; max-height: ' + max_height">
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
            max_height: {
                type: String | null,
                default: null,
                optional: true,
            },
            fields: {
                type: Array,
                default: () => ['id', 'version', 'name', 'created_at', 'created_by'],
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
