import PasswordsState from "../states/PasswordsState";
import IPassword from "../../types/IPassword";
import {ActionContext, StoreOptions} from "vuex";
import RootState from "../states/RootState";
import IPagination from "../../types/IPagination";
import api from "../../api";
import Vue from "vue";

const state = {
    fetched: {},
    links: null,
    meta: null,
} as PasswordsState;

const getters = {
    all(state: PasswordsState): IPassword[] {
        return Object.keys(state.fetched).map(id => state.fetched[id]);
    },

    byId(state: PasswordsState, id: string): IPassword | null {
        return state.fetched[id];
    }
};

const actions = {
    async fetchNextPage({state, commit}: ActionContext<PasswordsState, RootState>): Promise<IPagination<IPassword>> {
        // get next page from api
        let pagination = await api.passwords.list(state.links);

        commit('storeData', pagination);

        return pagination;
    },

    async get({state, getters, commit}: ActionContext<PasswordsState, RootState>, payload: { id: string }): Promise<IPassword | null> {
        let password = getters['byId'](payload.id);
        if (password !== null)
            return password;

        // fetch password from api
        password = await api.passwords.get(payload.id);

        commit('storePassword', password);

        return password;
    },

    async delete({commit}: ActionContext<PasswordsState, RootState>, payload: { id: string }): Promise<boolean> {
        // remove password from api
        let success = await api.passwords.delete(payload.id);

        commit('removePassword', payload.id);

        return success;
    },

    async update({commit}: ActionContext<PasswordsState, RootState>, payload: { password: IPassword }): Promise<IPassword> {
        // update password in api
        let updatedPassword = await api.passwords.update(payload.password);

        commit('storePassword', updatedPassword);

        return updatedPassword;
    }
};

const mutations = {
    storePassword(state: PasswordsState, password: IPassword) {
        if (password === null)
            throw new Error("password cannot be null!");

        Vue.set(state.fetched, password.id, password);
    },

    storeData(state: PasswordsState, pagination: IPagination<IPassword>) {
        pagination.data.forEach(p => Vue.set(state.fetched, p.id, p));

        state.meta = pagination.meta;
        state.links = pagination.links;
    },

    removePassword(state: PasswordsState, id: string) {
        if (id === null)
            throw new Error("id cannot be null!");

        Vue.delete(state.fetched, id);
    },
};

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations
} as StoreOptions<PasswordsState>;
