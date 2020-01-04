<template>
    <div>
        <div v-show="table_items.length > 0">
            <b-table
                    :current-page="current_page"
                    :fields="table_fields"
                    :items="table_items"
                    :per-page="per_page"
                    :responsive="true"
                    :stacked="type === 'list'"
                    borderless
                    hover
                    no-provider-sorting
                    primary-key="id"
                    ref="table"
                    small
                    striped
            >
                <template v-slot:cell()="data">
                    <span class="nobr">{{ data.value }}</span>
                </template>

                <template v-slot:cell(id)="data">
                    <code class="nobr">{{ data.value }}</code>
                </template>

                <template v-slot:cell(value)="data">
                    <spoiler :context="data.item.id" :value_provider="fetchPassword" />
                </template>

                <template v-slot:cell(actions)="data">
                    <slot>
                        <router-link :to="'/passwords/' + data.item.id" v-if="data.item.editable">edit</router-link>
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

            <b-pagination :per-page="per_page" :total-rows="total" @change="loadPage" v-model="current_page" />
        </div>

        <b-alert :show="table_items.length === 0" variant="info">
            There are no passwords to show.
        </b-alert>
    </div>
</template>

<script>
    import { mapGetters, mapState } from 'vuex';
    import Spoiler from './Spoiler';
    import api from '../api';

    export default {
        components: { Spoiler },
        props: {
            items: Array | Function,
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

        data() {
            return {
                current_page: 1,
                per_page: 50,
                total: 0,
            };
        },

        async mounted() {
            await this.loadPage(1, true);
        },

        methods: {
            refresh() {
                this.loadPage(this.current_page, true);
            },

            async fetchPassword(id) {
                return (await api.passwords.get(id)).value;
            },

            async loadPage(page, force = false) {
                if (!force && page * this.per_page <= this.total) return;

                this.$emit('loading-page', page);

                let result = await this.$store.dispatch('passwords/fetch', { page, per_page: this.per_page });

                this.current_page = result.meta.current_page;
                this.total = result.meta.total;
                this.per_page = result.meta.per_page;

                this.$emit('loaded-page', result.data.length);
            },
        },

        computed: {
            ...mapGetters('passwords', ['all']),
            ...mapState(['auth']),

            table_fields() {
                return this.fields.map(field => {
                    return {
                        key: field,
                        sortable: true,
                    };
                });
            },

            table_items() {
                return this.all.map(password => {
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
        },
    };
</script>
