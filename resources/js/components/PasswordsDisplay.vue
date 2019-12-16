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
    </b-table>
</template>

<script>
import { mapState } from 'vuex';
import Spoiler from './Spoiler';

export default {
    components: { Spoiler },
    props: {
        passwords: Array,
        autoload_more: {
            type: Boolean,
            default: true,
        },
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
                    ].includes(field)
                ),
        },
    },

    methods: {
        async fetchPassword(id) {
            await new Promise(resolve => setTimeout(resolve, 1000));

            console.log('Fetched value for ' + id);

            return 'value of ' + id;
        },
    },

    computed: {
        ...mapState(['auth']),

        table_items() {
            return this.passwords.map(password => {
                const data = { ...password };

                if (password.deleted_at !== null) data._rowVariant = 'danger';

                if (password.created_by?.id !== this.auth.user?.id) data._cellVariants = { created_by: 'secondary' };

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
