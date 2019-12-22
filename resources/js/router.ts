import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";

import Home from "./views/Home.vue";
import Login from "./views/Login.vue";
import Passwords from "./views/passwords/Passwords.vue";
import PasswordsOverview from "./views/passwords/PasswordsOverview.vue";
import EditPassword from "./views/passwords/EditPassword.vue";
import NotFound from "./views/NotFound.vue";
import {Route} from "vue-router/types/router";

Vue.use(VueRouter);

export const loginRoute = {name: 'login', path: '/login'};
export const homeRoute = {name: 'home', path: '/'};

class VueRouterExtended extends VueRouter {
    async continue(fallback: Route): Promise<void> {
        const continue_with: string = this.currentRoute.query.continue_with as string;

        if (continue_with !== undefined && continue_with !== null)
            await this.replace({path: continue_with}); // redirect to intended route (if given)
        else if (this.currentRoute.meta.requiresGuest)
            await this.push(fallback); // redirect to fallback route
    }
}

const router = new VueRouterExtended({
    mode: 'history',
    linkExactActiveClass: "active",

    routes: [
        {
            path: homeRoute.path,
            name: homeRoute.name,
            component: Home,
            meta: {
                requiresAuth: true,
            }
        },
        {
            path: loginRoute.path,
            name: loginRoute.name,
            component: Login,
            meta: {
                requiresGuest: true,
            }
        },
        {
            path: '/passwords',
            component: Passwords,
            meta: {
                requiresAuth: true,
            },
            children: [
                {
                    path: '',
                    name: 'passwords',
                    component: PasswordsOverview,
                },
                {
                    path: ':id',
                    component: EditPassword
                }
            ]
        },
        {
            path: '*',
            component: NotFound
        }
    ],
});

router.beforeEach((to, from, next) => {
    const authenticated = store.getters['auth/isAuthenticated'];
    const requiresGuest = to.matched.some(record => record.meta.requiresGuest);
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (authenticated) {
        if (requiresGuest)
            next(homeRoute);
        else
            next();
    } else {
        if (requiresAuth) {
            next({name: loginRoute.name, replace: true, query: {continue_with: to.path}});
        } else
            next();
    }
});

export default router;
