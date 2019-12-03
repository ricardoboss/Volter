import {ApiState} from "../states/ApiState";
import {ActionContext, StoreOptions} from "vuex";
import {RootState} from "../states/RootState";

// TODO: add nested api request support (semaphore which counts how many requests are waiting to finish) and set loading appropriately
const state = {
    loading: false,
} as ApiState;

const getters = {};

const actions = {
    setLoading({state, commit}: ActionContext<ApiState, RootState>, payload: boolean) {
        if (payload != state.loading)
            commit('setLoading', payload);
    }
};

const mutations = {
    setLoading(state: ApiState, value: boolean) {
        state.loading = value;
    }
};

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations,
} as StoreOptions<ApiState>;
