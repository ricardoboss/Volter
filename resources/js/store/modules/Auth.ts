import {ActionContext, Commit, StoreOptions} from "vuex";
import {RootState} from "../states/RootState";
import {AuthState} from "../states/AuthState";
import {JsonWebToken} from "../../types/JsonWebToken";
import {User} from "../../types/User";
import Vue from "vue";
import auth from "../../api/auth";

const requestUser = async (commit: Commit, token: JsonWebToken): Promise<User | null> => {
    commit('setLoadingUser', true);

    try {
        // request user data using token
        let user = await auth.me(token);

        // store token in state
        commit('setUser', user);

        return user;
    } catch (e) {
        console.error("Error while getting user with local token.");
        console.error(e);

        // remove token because no user information could be retrieved using it
        commit('unsetToken');

        return null;
    } finally {
        commit('setLoadingUser', false);
    }
};

const state = {
    loadingUser: false,
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
        let token: JsonWebToken | null = null;
        try {
            token = await auth.login(payload.email, payload.password);
        } catch (e) {
            console.error("Error while trying to get token with provided login information.");
            console.error(e);
        }

        if (token === null)
            return null;

        // store the token in local storage
        window.localStorage.setItem('token', JSON.stringify(token));

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

    async logout(context: ActionContext<AuthState, RootState>): Promise<void> {
        // get token from local storage
        let token = context.getters.getTokenFromStorage;
        if (token === null)
            return;

        try {
            // logout from the api
            await auth.logout(token);
        } catch (e) {
            console.warn("Unable to invalidate token.");
        }

        // remove token from local storage
        window.localStorage.removeItem('token');

        // unset the values
        context.commit('unsetToken');
        context.commit('unsetUser');
    }
};

const mutations = {
    setLoadingUser(state: AuthState, loading: boolean) {
        state.loadingUser = loading;
    },

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
