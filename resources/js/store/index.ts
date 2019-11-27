import Vue from "vue"
import Vuex, {ActionContext, StoreOptions} from "vuex"
import {RootState} from "./RootState";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        theme: 'light'
    },

    actions: {
        setLightTheme(context: ActionContext<RootState, RootState>) {
            context.commit('setTheme', 'light')
        },

        setDarkTheme(context: ActionContext<RootState, RootState>) {
            context.commit('setTheme', 'dark')
        }
    },

    mutations: {
        setTheme(state: RootState, theme: string) {
            state.theme = theme;
        }
    },

    getters: {
        getTheme: state => state.theme,
    }
} as StoreOptions<RootState>)
