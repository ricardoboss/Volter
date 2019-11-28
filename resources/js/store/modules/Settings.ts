import {ActionContext, StoreOptions} from "vuex";
import {RootState} from "../states/RootState";
import {SettingsState} from "../states/SettingsState";

const state = {
    theme: 'dark'
} as SettingsState;

const getters = {
    getTheme: (state: SettingsState) => state.theme
};

const actions = {
    setLightTheme(context: ActionContext<SettingsState, RootState>) {
        context.commit('setTheme', 'light')
    },

    setDarkTheme(context: ActionContext<SettingsState, RootState>) {
        context.commit('setTheme', 'dark')
    }
};

const mutations = {
    setTheme(state: SettingsState, theme: string) {
        state.theme = theme;
    }
};

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations
} as StoreOptions<SettingsState>;
