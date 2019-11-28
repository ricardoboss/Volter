import Vue from "vue"
import Vuex, {StoreOptions} from "vuex"
import {RootState} from "./states/RootState";
import settings from "./modules/Settings";

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',

    modules: {
        settings
    }
} as StoreOptions<RootState>)
