import {Password} from "../types/Password";
import {AxiosResponse} from "axios";
import {ApiResponse} from "../types/ApiResponse";
import Vue from "vue";
import {PaginationResponse} from "../types/PaginationResponse";
import {PaginationData} from "../types/PaginationData";

const endpoints = {
    list: '/api/passwords',
    create: '/api/passwords',
    view: '/api/passwords/{password}',
    edit: '/api/passwords/{password}',
    delete: '/api/passwords/{password}',
    destroy: '/api/passwords/{password}/destroy',
    share: '/api/passwords/{password}/share',
};

function inject(url: string, queryParams: any) {
    if (queryParams === null)
        return url;

    let params = new URLSearchParams();

    Object.keys(queryParams).forEach(key => {
        if (url.indexOf("{" + key + "}") >= 0)
            url.replace("{" + key + "}", queryParams[key]);
        else
            params.append(key, queryParams[key]);
    });

    if (params.toString().length > 0)
        url += "?" + params.toString();

    return url;
}

async function list(data: PaginationData<Password> | Record<string, string> | null): Promise<PaginationData<Password>> {
    let response: AxiosResponse<PaginationResponse<Password>> = await Vue.axios.get(inject(endpoints.list, {
        count: data === null ? 15 : data.count
    }));

    console.log(response);

    return response.data.result;
}

async function create(name: string, notes: string, value: string): Promise<Password> {
    if (name === null || value === null)
        throw new Error("name nor value can be null!");

    // TODO: encrypt value before transmission

    let response: AxiosResponse<ApiResponse<Password>> = await Vue.axios.post(
        endpoints.create,
        {
            name,
            notes,
            value
        });

    return response.data.result;
}

async function get(id: string): Promise<Password> {
    if (id === null)
        throw new Error("id cannot be null!");

    let response: AxiosResponse<ApiResponse<Password>> = await Vue.axios.get(inject(endpoints.view, {
        password: id
    }));

    return response.data.result;
}

async function edit(password: Password): Promise<Password> {
    if (password === null)
        throw new Error("password cannot be null!");

    let response: AxiosResponse<ApiResponse<Password>> = await Vue.axios.put(
        inject(endpoints.edit, {
            password: password.id
        }),
        password
    );

    return response.data.result;
}

async function _delete(id: string): Promise<boolean> {
    if (id === null)
        throw new Error("id cannot be null!");

    let response: AxiosResponse<ApiResponse<boolean>> = await Vue.axios.delete(
        inject(endpoints.delete, {
            password: id
        })
    );

    return response.data.result;
}

async function destroy(password: Password): Promise<boolean> {
    if (password === null)
        throw new Error("password cannot be null!");

    let response: AxiosResponse<ApiResponse<boolean>> = await Vue.axios.delete(
        inject(endpoints.destroy, {
            password: password.id
        })
    );

    return response.data.result;
}

async function share(password: Password): Promise<any> {
    if (password === null)
        throw new Error("password cannot be null!");

    let response: AxiosResponse<ApiResponse<any>> = await Vue.axios.post(
        inject(endpoints.share, {
            password: password.id
        })
    );

    return response.data.result;
}

export default {
    list,
    create,
    get,
    edit,
    delete: _delete,
    destroy,
    share
}
