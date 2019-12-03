import Vue from "vue";
import {JsonWebToken} from "../types/JsonWebToken";
import {User} from "../types/User";
import {ApiResponse} from "../types/ApiResponse";
import {AxiosResponse} from "axios";

const endpoints = {
    login: '/api/auth/login',
    logout: '/api/auth/logout',
    me: '/api/auth/me',
    refresh: '/api/auth/refresh',
};

// TODO: extract same structure for requests into a simpler interface (`api.post(...)`, `api.get(...)`, etc.)

async function login(email: String, password: String): Promise<JsonWebToken> {
    if (email === null || password === null)
        throw new Error("email nor password can be null!");

    let response: AxiosResponse<ApiResponse<JsonWebToken>> = await Vue.axios.post(
        endpoints.login,
        {
            email,
            password
        });

    return response.data.result;
}

async function logout(token: JsonWebToken): Promise<boolean> {
    if (token === null)
        throw new Error("token cannot be null!");

    let response: AxiosResponse<ApiResponse<boolean>> = await Vue.axios.post(
        endpoints.logout,
        {},
        {
            headers: {
                'Authorization': token.token_type + ' ' + token.access_token
            }
        });

    return response.data.result;
}

async function me(token: JsonWebToken): Promise<User> {
    if (token === null)
        throw new Error("token cannot be null!");

    let response: AxiosResponse<ApiResponse<User>> = await Vue.axios.get(
        endpoints.me,
        {
            headers: {
                'Authorization': token.token_type + ' ' + token.access_token
            }
        });

    return response.data.result;
}

async function refresh(token: JsonWebToken): Promise<JsonWebToken> {
    if (token === null)
        throw new Error("token cannot be null!");

    let response: AxiosResponse<ApiResponse<JsonWebToken>> = await Vue.axios.get(
        endpoints.refresh,
        {
            headers: {
                'Authorization': token.token_type + ' ' + token.access_token
            }
        });

    return response.data.result;
}

export default {
    login,
    logout,
    me,
    refresh,
}
