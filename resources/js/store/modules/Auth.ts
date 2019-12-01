import {ActionContext, StoreOptions} from "vuex";
import {RootState} from "../states/RootState";
import {AuthState} from "../states/AuthState";
import {JsonWebToken} from "../../types/JsonWebToken";
import {User} from "../../types/User";
import Vue from "vue";
import auth from "../../api/auth";

const state = {
    token: null,
    user: null,
} as AuthState;

const getters = {
    isAuthenticated() {
        return getters.getTokenFromStorage() !== null && state.user !== null;
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
    async login({dispatch}: ActionContext<AuthState, RootState>, payload: { email: string, password: string }): Promise<{ user: User, token: JsonWebToken } | null> {
        // try to get a token using the provided credentials
        let token = await auth.login(payload.email, payload.password);
        if (token === null)
            return null;

        // store the token in local storage
        window.localStorage.setItem('token', JSON.stringify(token));

        // call next action to log in using the stored token
        return await dispatch('loginFromStorage');
    },

    async loginFromStorage(context: ActionContext<AuthState, RootState>): Promise<{ user: User, token: JsonWebToken } | null> {
        // get token from local storage
        let token = context.getters.getTokenFromStorage;
        if (token === null)
            return null;

        // request user information
        let user = await auth.me(token);
        if (user === null)
            return null;

        // commit values to state
        context.commit('setToken', token);
        context.commit('setUser', user);

        return {user, token};
    },

    async logout(context: ActionContext<AuthState, RootState>): Promise<void> {
        // get token from local storage
        let token = context.getters.getTokenFromStorage;
        if (token === null)
            return;

        // logout from the api
        await auth.logout(token);

        // remove token from local storage
        window.localStorage.removeItem('token');

        // unset the values
        context.commit('unsetToken');
        context.commit('unsetUser');
    }
};

const mutations = {
    unsetToken(state: AuthState) {
        console.log("Resetting token");

        Vue.axios.defaults.headers.common['Authorization'] = null;

        state.token = null;
    },

    setToken(state: AuthState, token: JsonWebToken) {
        if (token === null)
            throw new Error("Cannot set token to null. Use unsetToken for this.");

        console.log("Setting token");

        Vue.axios.defaults.headers.common['Authorization'] = token.token_type + ' ' + token.access_token;

        state.token = token;
    },

    unsetUser(state: AuthState) {
        console.log("Resetting user");

        state.user = null;
    },

    setUser(state: AuthState, user: User) {
        if (user === null)
            throw new Error("Cannot set user to null. Use unsetUser for this.");

        console.log("Setting user");

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
