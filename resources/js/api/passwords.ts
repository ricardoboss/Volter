import IPassword from "../types/IPassword";
import {AxiosResponse} from "axios";
import IApiResponse from "../types/IApiResponse";
import Vue from "vue";
import IPagination, {IPaginationLinks} from "../types/IPagination";

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
            url = url.replace("{" + key + "}", queryParams[key]);
        else
            params.append(key, queryParams[key]);
    });

    if (params.toString().length > 0)
        url += "?" + params.toString();

    return url;
}

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

    // TODO: encrypt value before transmission

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

async function edit(password: IPassword): Promise<IPassword> {
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
    edit,
    delete: _delete,
    destroy,
    share
}
