<template>
    <b-table
        :items="table_items"
        :fields="table_fields"
        primary-key="id"
        hover
        striped
        borderless
        small
        :responsive="true"
        :stacked="type === 'list'"
    >
        <template v-slot:cell()="data">
            <span class="nobr">{{ data.value }}</span>
        </template>

        <template v-slot:cell(id)="data">
            <code class="nobr">{{ data.value }}</code>
        </template>

        <template v-slot:cell(value)="data">
            <spoiler :value_provider="fetchPassword" :context="data.item.id" />
        </template>

        <template v-slot:cell(actions)="data">
            <slot>
                <router-link v-if="data.item.editable" :to="'/passwords/' + data.item.id">edit</router-link>
            </slot>
        </template>

        <template v-slot:cell(created_at)="data">
            <span class="nobr">{{ new Date(data.value).toLocaleString() }}</span>
        </template>

        <template v-slot:cell(updated_at)="data">
            <span class="nobr">{{ new Date(data.value).toLocaleString() }}</span>
        </template>

        <template v-slot:cell(deleted_at)="data">
            <span class="nobr">{{ new Date(data.value).toLocaleString() }}</span>
        </template>
    </b-table>
</template>

<script>
    import { mapState } from 'vuex';
    import Spoiler from './Spoiler';
    import api from '../api';

    export default {
        components: { Spoiler },
        props: {
            passwords: Array,
            type: {
                type: String,
                default: 'table',
                validator: val => ['table', 'list'].includes(val),
            },
            fields: {
                type: Array,
                default: () => ['id', 'version', 'name', 'created_at', 'created_by'],
                validator: val =>
                    val.every(field =>
                        [
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
                            'actions',
                        ].includes(field)
                    ),
            },
        },

        methods: {
            fetchPassword: async id => (await api.passwords.get(id)).value,
        },

        computed: {
            ...mapState(['auth']),

            table_items() {
                return this.passwords.map(password => {
                    const data = { ...password };

                    if (password.deleted_at !== null) data._rowVariant = 'danger';

                    if (password.created_by?.id !== this.auth.user?.id)
                        data._cellVariants = { created_by: 'secondary' };

                    data.created_by = password.created_by.name;
                    data.updated_by = password.updated_by?.name ?? null;
                    data.deleted_by = password.deleted_by?.name ?? null;

                    return data;
                });
            },

            table_fields() {
                return this.fields.map(field => {
                    return {
                        key: field,
                        sortable: true,
                    };
                });
            },
        },
    };
</script>
