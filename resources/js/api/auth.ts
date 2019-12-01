import Vue from "vue";
import {JsonWebToken} from "../types/JsonWebToken";
import {User} from "../types/User";

const endpoints = {
    login: '/api/auth/login',
    logout: '/api/auth/logout',
    me: '/api/auth/me',
    refresh: '/api/auth/refresh',
};

function login(email: String, password: String): Promise<null | JsonWebToken> {
    if (email === null || password === null)
        throw new Error("email nor password can be null!");

    return Vue.axios
        .post(endpoints.login, {
            email,
            password
        })
        .then(r => r.data.result as JsonWebToken)
        .catch(e => {
            console.error("Error while performing login: ", e);

            return null;
        });
}

function logout(token: JsonWebToken): Promise<boolean> {
    if (token === null)
        throw new Error("token cannot be null!");

    return Vue.axios({
        method: 'post',
        url: endpoints.logout,
        headers: {
            'Authorization': token.token_type + ' ' + token.access_token
        }
    })
        .then(r => r.data.result as boolean)
        .catch(e => {
            console.error("Error while performing logout: ", e);

            return false;
        });
}

function me(token: JsonWebToken): Promise<null | User> {
    if (token === null)
        throw new Error("token cannot be null!");

    return Vue.axios
        .get(endpoints.me, {
            headers: {
                'Authorization': token.token_type + ' ' + token.access_token
            }
        })
        .then(r => r.data.result as User)
        .catch(e => {
            console.error("Error while requesting user data: " + e);

            return null;
        });
}

function refresh(token: JsonWebToken): Promise<null | JsonWebToken> {
    if (token === null)
        throw new Error("token cannot be null!");

    return Vue.axios
        .get(endpoints.refresh, {
            headers: {
                'Authorization': token.token_type
            }
        })
}

export default {
    login,
    logout,
    me,
}
