import Vue from "vue";
import IUser from "../types/IUser";
import IApiResponse from "../types/IApiResponse";
import {AxiosResponse} from "axios";
import JsonWebToken from "../types/JsonWebToken";

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

    let response: AxiosResponse<IApiResponse<JsonWebToken>>;
    try {
        response = await Vue.axios.post(
            endpoints.login,
            {
                email,
                password
            });

        return response.data.data;
    } catch (e) {
        if (
            typeof e !== 'undefined' &&
            e.hasOwnProperty("data") &&
            e.data.hasOwnProperty("data") &&
            e.data.data.hasOwnProperty("message")
        ) {
            throw e.data.data.message;
        }

        throw e;
    }
}

async function logout(token: JsonWebToken): Promise<boolean> {
    if (token === null)
        throw new Error("token cannot be null!");

    let response: AxiosResponse<IApiResponse<boolean>> = await Vue.axios.post(
        endpoints.logout,
        {},
        {
            headers: {
                'Authorization': token.token_type + ' ' + token.access_token
            }
        });

    return response.data.data;
}

async function me(token: JsonWebToken): Promise<IUser> {
    if (token === null)
        throw new Error("token cannot be null!");

    let response: AxiosResponse<IApiResponse<IUser>> = await Vue.axios.get(
        endpoints.me,
        {
            headers: {
                'Authorization': token.token_type + ' ' + token.access_token
            }
        });

    return response.data.data;
}

async function refresh(token: JsonWebToken): Promise<JsonWebToken> {
    if (token === null)
        throw new Error("token cannot be null!");

    let response: AxiosResponse<IApiResponse<JsonWebToken>> = await Vue.axios.get(
        endpoints.refresh,
        {
            headers: {
                'Authorization': token.token_type + ' ' + token.access_token
            }
        });

    return response.data.data;
}

export default {
    login,
    logout,
    me,
    refresh,
}
