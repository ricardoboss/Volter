import {PasswordsState} from "../states/PasswordsState";
import {Password} from "../../types/Password";
import {ActionContext, StoreOptions} from "vuex";
import {RootState} from "../states/RootState";
import passwords from "../../api/passwords";

const state = {
    passwords: {} as Map<string, Password>,
} as PasswordsState;

const getters = {
    isFetched(state: PasswordsState, id: string) {
        return state.passwords.has(id);
    },
};

const actions = {
    async fetch({state, getters, commit}: ActionContext<PasswordsState, RootState>, payload: { id: string }): Promise<Password> {
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
            throw new Error("password cannot be null");

        state.passwords.set(password.id, password);
    },

    removePassword(state: PasswordsState, id: string) {
        if (id === null)
            throw new Error("id cannot be null!");

        state.passwords.delete(id);
    },
};

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations
} as StoreOptions<PasswordsState>;
