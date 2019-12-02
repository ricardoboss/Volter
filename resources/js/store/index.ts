import Vue from "vue"
import Vuex, {StoreOptions} from "vuex"
import {RootState} from "./states/RootState";

import api from "./modules/Api";
import auth from "./modules/Auth";

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',

    modules: {
        api,
        auth,
    }
} as StoreOptions<RootState>)
