import {Password} from "../types/Password";
import {AxiosResponse} from "axios";
import {ApiResponse} from "../types/ApiResponse";
import Vue from "vue";
import {PaginationData, PaginationResponse} from "../types/PaginationResponse";

const endpoints = {
    list: '/api/passwords',
    create: '/api/passwords',
    view: '/api/passwords/{password}',
    edit: '/api/passwords/{password}',
    delete: '/api/passwords/{password}',
    destroy: '/api/passwords/{password}/destroy',
    share: '/api/passwords/{password}/share',
};

function inject(url: string, queryParams: Record<string, string>) {
    Object.keys(queryParams).forEach()

    if (Object.keys(queryParams).length == 0)
        return url;

    let params = new URLSearchParams(queryParams);

    return url + '?' + params.toString();
}

async function list(data: PaginationData<Password> | Record<string, string> | null): Promise<PaginationData<Password>> {
    if (data === null)
        data = {};

    let response: AxiosResponse<PaginationResponse<Password>> = await Vue.axios.get(inject(endpoints.list, data));

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

async function view(id: string): Promise<Password> {
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
        endpoints.edit,
        password
    );

    return response.data.result;
}

async function _delete(password: Password): Promise<boolean> {
    if (password === null)
        throw new Error("password cannot be null!");

    let response: AxiosResponse<ApiResponse<boolean>> = await Vue.axios.delete(
        endpoints.delete,
    );

    return response.data.result;
}

async function destroy(password: Password): Promise<boolean> {
    if (password === null)
        throw new Error("password cannot be null!");
}

async function share(password: Password): Promise<any> {
    if (password === null)
        throw new Error("password cannot be null!");
}

export default {
    list,
    create,
    view,
    edit,
    delete: _delete,
    destroy,
    share
}
