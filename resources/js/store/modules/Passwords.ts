import {PasswordsState} from "../states/PasswordsState";
import {Password} from "../../types/Password";
import {ActionContext, StoreOptions} from "vuex";
import {RootState} from "../states/RootState";
import passwords from "../../api/passwords";
import {PaginationData} from "../../types/PaginationData";

const state = {
    passwords: new Map<string, Password>(),
    latestPagination: null,
} as PasswordsState;

const getters = {
    isFetched(state: PasswordsState, id: string) {
        return state.passwords.has(id);
    },
};

const actions = {
    async fetch({state, getters, commit}: ActionContext<PasswordsState, RootState>, payload: PaginationData<Password>): Promise<Password[]> {
        if (state.latestPagination === null) {
            commit('setLatestPaginationData', payload);
        }

        let list = await passwords.list(state.latestPagination);

        if (typeof list.data === 'undefined')
            throw new Error("no data returned!");

        commit('storeAll', list.data);

        return list.data;
    },

    async fetchOne({state, getters, commit}: ActionContext<PasswordsState, RootState>, payload: { id: string }): Promise<Password> {
        if (getters['isFetched'](payload.id))
            return state.passwords.get(payload.id) as Password;

        let password = await passwords.get(payload.id);

        commit('storePassword', password);

        return password;
    },

    async delete({commit}: ActionContext<PasswordsState, RootState>, payload: { id: string }): Promise<boolean> {
        let success = await passwords.delete(payload.id);

        commit('removePassword', payload.id);

        return success;
    },

    async update({commit}: ActionContext<PasswordsState, RootState>, payload: { password: Password }): Promise<Password> {
        let updatedPassword = await passwords.edit(payload.password);

        commit('storePassword', updatedPassword);

        return updatedPassword;
    }
};

const mutations = {
    storePassword(state: PasswordsState, password: Password) {
        if (password === null)
            throw new Error("password cannot be null!");

        state.passwords.set(password.id, password);
    },

    storeAll(state: PasswordsState, passwords: Password[]) {
        if (passwords === null)
            throw new Error("passwords cannot be null!");

        passwords.forEach(p => state.passwords.set(p.id, p));
    },

    removePassword(state: PasswordsState, id: string) {
        if (id === null)
            throw new Error("id cannot be null!");

        state.passwords.delete(id);
    },

    setLatestPaginationData(state: PasswordsState, data: PaginationData<Password>) {
        if (data === null)
            throw new Error("data cannot be null!");

        state.latestPagination = data;
    },
};

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations
} as StoreOptions<PasswordsState>;
