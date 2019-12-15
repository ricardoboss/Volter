import {ActionContext, Commit, StoreOptions} from "vuex";
import {RootState} from "../states/RootState";
import {AuthState} from "../states/AuthState";
import {JsonWebToken} from "../../types/JsonWebToken";
import {User} from "../../types/User";
import Vue from "vue";
import api from "../../api";

const requestUser = async (commit: Commit, token: JsonWebToken): Promise<User> => {
    try {
        // request user data using token
        let user = await api.auth.me(token);

        // store user in state
        commit('setUser', user);

        return user;
    } catch (e) {
        // remove token because no user information could be retrieved using it
        commit('unsetToken');

        throw e;
    }
};

const state = {
    token: null,
    user: null,
} as AuthState;

const getters = {
    isAuthenticated() {
        return state.token !== null && state.user !== null;
    },

    getTokenFromStorage(): JsonWebToken | null {
        // check if token is set in localStorage
        let json_token = window.localStorage.getItem('token');
        if (json_token === null)
            return null;

        // parse token as JsonWebToken
        return JSON.parse(json_token) as JsonWebToken;
    },
};

const actions = {
    async login({dispatch, commit}: ActionContext<AuthState, RootState>, payload: { email: string, password: string }): Promise<{ user: User, token: JsonWebToken } | null> {
        // TODO: check if already authenticated and maybe refresh token

        // try to get a token using the provided credentials
        let token = await api.auth.login(payload.email, payload.password);

        // store token in state
        commit('setToken', token);

        // get user
        let user = await requestUser(commit, token);
        if (user === null)
            return null;

        // request user information using the token

        return {user, token};
    },

    async loginFromStorage({commit, getters}: ActionContext<AuthState, RootState>): Promise<{ user: User, token: JsonWebToken } | null> {
        // get token from local storage
        let token = getters.getTokenFromStorage;
        if (token === null)
            return null;

        // commit token to state
        commit('setToken', token);

        // request user information
        let user = await requestUser(commit, token);
        if (user === null)
            return null;

        return {user, token};
    },

    async logout({commit, getters}: ActionContext<AuthState, RootState>): Promise<void> {
        // get token from local storage
        let token = getters.getTokenFromStorage;
        if (token === null)
            return;

        const concreteToken = {...token};

        // TODO: clear storage

        // unset the values
        commit('unsetToken');
        commit('unsetUser');

        try {
            // logout from the api
            await api.auth.logout(concreteToken);
        } catch (e) {
            throw new Error("Token invalidation failed. Assuming it is already invalid. Error: " + e.message);
        }
    }
};

const mutations = {
    unsetToken(state: AuthState) {
        // remove token from local storage
        window.localStorage.removeItem('token');

        // reset default authorization header for requests
        Vue.axios.defaults.headers.common['Authorization'] = null;

        state.token = null;
    },

    setToken(state: AuthState, token: JsonWebToken) {
        if (token === null)
            throw new Error("Cannot set token to null. Use unsetToken for this.");

        // store the token in local storage
        window.localStorage.setItem('token', JSON.stringify(token));

        // set default authorization header for requests
        Vue.axios.defaults.headers.common['Authorization'] = token.token_type + ' ' + token.access_token;

        state.token = token;
    },

    unsetUser(state: AuthState) {
        state.user = null;
    },

    setUser(state: AuthState, user: User) {
        if (user === null)
            throw new Error("Cannot set user to null. Use unsetUser for this.");

        state.user = user;
    },
};

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations
} as StoreOptions<AuthState>;
