import {PasswordsState} from "../states/PasswordsState";
import {Password} from "../../types/Password";
import {ActionContext, StoreOptions} from "vuex";
import {RootState} from "../states/RootState";
import {Pagination, PaginationLinks, PaginationMeta} from "../../types/Pagination";
import api from "../../api";

const state = {
    fetched: {},
    links: null,
    meta: null,
} as PasswordsState;

const getters = {
    all(state: PasswordsState): Password[] {
        return Object.values(state.fetched);
    },

    byId(state: PasswordsState, id: string): Password | null {
        return state.fetched[id];
    }
};

const actions = {
    async fetchNextPage({state, commit}: ActionContext<PasswordsState, RootState>): Promise<Pagination<Password>> {
        // get next page from api
        let pagination = await api.passwords.list(state.links);

        commit('storeMeta', pagination.meta);
        commit('storeLinks', pagination.links);
        commit('storeAll', pagination.data);

        return pagination;
    },

    async get({state, getters, commit}: ActionContext<PasswordsState, RootState>, payload: { id: string }): Promise<Password | null> {
        let password = getters.byId(payload.id);
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

    async update({commit}: ActionContext<PasswordsState, RootState>, payload: { password: Password }): Promise<Password> {
        // update password in api
        let updatedPassword = await api.passwords.edit(payload.password);

        commit('storePassword', updatedPassword);

        return updatedPassword;
    }
};

const mutations = {
    storePassword(state: PasswordsState, password: Password) {
        if (password === null)
            throw new Error("password cannot be null!");

        state.fetched[password.id] = password;
    },

    storeAll(state: PasswordsState, passwords: Password[]) {
        if (passwords === null)
            throw new Error("passwords cannot be null!");

        passwords.forEach(p => state.fetched[p.id] = p);
    },

    removePassword(state: PasswordsState, id: string) {
        if (id === null)
            throw new Error("id cannot be null!");

        delete state.fetched[id];
    },

    storeMeta(state: PasswordsState, meta: PaginationMeta | null) {
        state.meta = meta;
    },

    storeLinks(state: PasswordsState, links: PaginationLinks | null) {
        state.links = links;
    }
};

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations
} as StoreOptions<PasswordsState>;
