<template>
    <b-form class="my-4" @submit.prevent="$emit('submit', model)">
        <b-form-group
            label="Name"
            label-for="name"
            description="An easy to identify and unique name for this password."
        >
            <b-form-input
                id="name"
                :readonly="!editable"
                v-model="model.name"
                type="text"
                required
                autofocus
                placeholder="Please enter a name (required)"
                autocomplete="off"
                autofill="off"
                tabindex="1"
            />
        </b-form-group>

        <b-form-group
            label="Notes"
            label-for="notes"
            description="A description of the service this password is used for."
        >
            <b-textarea tabindex="2" id="notes" placeholder="(optional)" :readonly="!editable" v-model="model.notes" style="min-height: 5rem" />
        </b-form-group>

        <b-form-row>
            <b-col cols="12">
                <label for="value">Value</label>
            </b-col>
        </b-form-row>
        <b-form-row>
            <b-col cols="12" lg="8">
                <b-form-group description="The passwords' value.">
                    <b-form-input
                        id="value"
                        v-model="model.value"
                        :readonly="!editable"
                        :type="value_revealed ? 'text' : 'password'"
                        autocomplete="new-password"
                        autofill="disabled"
                        @click="selectPassword"
                        required
                        placeholder="Please enter a new value (required)"
                        tabindex="3"
                    />
                </b-form-group>
            </b-col>
            <b-col cols="12" lg="4">
                <b-button-group class="d-flex">
                    <b-button
                        :variant="value_revealed ? 'warning' : 'outline-warning'"
                        v-text="(value_revealed ? 'Hide' : 'Show') + ' Password'"
                        @click="value_revealed = !value_revealed"
                        tabindex="5"
                    />
                    <b-button
                        v-if="generator_enabled"
                        :variant="generator_visible ? 'secondary' : 'outline-secondary'"
                        v-text="(generator_visible ? 'Hide' : 'Show') + ' Generator'"
                        @click="toggleGenerator"
                        tabindex="6"
                    />
                </b-button-group>
            </b-col>
        </b-form-row>
        <b-form-row v-if="generator_enabled" v-show="generator_visible">
            <b-col class="pt-3">
                <b-card>
                    <b-card-text>
                        <b-form-group :label="'Length: ' + generator_length" label-cols-sm="2">
                            <b-form-input type="range" v-model="generator_length" min="6" max="64" tabindex="7" />
                        </b-form-group>

                        <b-form-group>
                            <b-form-checkbox v-model="generator_symbols" tabindex="8">Symbols</b-form-checkbox>
                        </b-form-group>

                        <b-form-group>
                            <b-form-checkbox v-model="generator_numbers" tabindex="9">Numbers</b-form-checkbox>
                        </b-form-group>

                        <b-button variant="success" @click="generatePassword" tabindex="10">Generate new password</b-button>
                    </b-card-text>
                </b-card>
            </b-col>
        </b-form-row>

        <b-button class="mt-3" type="submit" variant="primary" :tabindex="generator_visible ? 11 : 4">Save</b-button>
    </b-form>
</template>

<script>
    import PasswordGenerator from '../services/PasswordGenerator';

    export default {
        props: {
            value: {
                type: Object,
            },
            editable: {
                type: Boolean,
                default: true,
            },
            generator: {
                type: Boolean,
                default: true,
            },
        },

        data() {
            return {
                model: this.value ?? this.emptyPassword(),
                original: Object.assign({}, this.value),
                value_revealed: false,

                generator_visible: false,
                generator_length: 16,
                generator_symbols: true,
                generator_numbers: true,
            };
        },

        methods: {
            emptyPassword() {
                return {
                    name: null,
                    notes: null,
                    value: null,
                }
            },

            toggleGenerator() {
                this.value_revealed = this.generator_visible = !this.generator_visible;
            },

            generatePassword() {
                this.value_revealed = true;

                this.model.value = PasswordGenerator.generate(
                    this.generator_length,
                    this.generator_symbols,
                    this.generator_numbers,
                    ['`'],
                    []
                );
            },

            selectPassword() {
                document.getElementById('value').select();
            },
        },

        computed: {
            generator_enabled() {
                return this.generator && this.editable;
            },
        },
    };
</script>
