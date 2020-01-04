import IPassword from "../types/IPassword";
import {AxiosResponse} from "axios";
import IApiResponse from "../types/IApiResponse";
import Vue from "vue";
import IPagination, {IPaginationLinks} from "../types/IPagination";
import {inject} from "./index";

const endpoints = {
    list: '/api/passwords',
    create: '/api/passwords',
    view: '/api/passwords/{password}',
    edit: '/api/passwords/{password}',
    delete: '/api/passwords/{password}',
    destroy: '/api/passwords/{password}/destroy',
    share: '/api/passwords/{password}/share',
};

async function list(data: IPaginationLinks | null = null): Promise<IPagination<IPassword>> {
    let url: string = endpoints.list;
    if (data !== null && data.next !== null)
        url = data.next;

    let response: AxiosResponse<IPagination<IPassword>> = await Vue.axios.get(url);

    return response.data;
}

async function create(name: string, notes: string, value: string): Promise<IPassword> {
    if (name === null || value === null)
        throw new Error("name nor value can be null!");

    let response: AxiosResponse<IApiResponse<IPassword>> = await Vue.axios.post(
        endpoints.create,
        {
            name,
            notes,
            value
        });

    return response.data.data;
}

async function get(id: string): Promise<IPassword> {
    if (id === null)
        throw new Error("id cannot be null!");

    let response: AxiosResponse<IApiResponse<IPassword>> = await Vue.axios.get(inject(endpoints.view, {
        password: id
    }));

    return response.data.data;
}

async function update(password: IPassword): Promise<IPassword> {
    if (password === null)
        throw new Error("password cannot be null!");

    let response: AxiosResponse<IApiResponse<IPassword>> = await Vue.axios.put(
        inject(endpoints.edit, {
            password: password.id
        }),
        password
    );

    return response.data.data;
}

async function _delete(id: string): Promise<boolean> {
    if (id === null)
        throw new Error("id cannot be null!");

    let response: AxiosResponse<IApiResponse<boolean>> = await Vue.axios.delete(
        inject(endpoints.delete, {
            password: id
        })
    );

    return response.data.data;
}

async function destroy(password: IPassword): Promise<boolean> {
    if (password === null)
        throw new Error("password cannot be null!");

    let response: AxiosResponse<IApiResponse<boolean>> = await Vue.axios.delete(
        inject(endpoints.destroy, {
            password: password.id
        })
    );

    return response.data.data;
}

async function share(password: IPassword): Promise<any> {
    if (password === null)
        throw new Error("password cannot be null!");

    let response: AxiosResponse<IApiResponse<any>> = await Vue.axios.post(
        inject(endpoints.share, {
            password: password.id
        })
    );

    return response.data.data;
}

export default {
    list,
    create,
    get,
    update,
    delete: _delete,
    destroy,
    share
}
