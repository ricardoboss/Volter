import {AxiosResponse} from "axios";
import IApiResponse from "../types/IApiResponse";
import Vue from "vue";
import {inject} from "./index";

const endpoints = {
    check: '/email/check',
    verify: '/email/verify/{id}/{hash}',
    resend: '/email/resend',
};

async function checkVerified(): Promise<boolean> {
    let response: AxiosResponse<IApiResponse<boolean>> = await Vue.axios.get(endpoints.check);

    return response.data.data;
}

async function verify(id: string, hash: string): Promise<boolean> {
    let response: AxiosResponse<IApiResponse<any>> = await Vue.axios.get(
        inject(
            endpoints.verify,
            {
                id,
                hash
            }
        )
    );

    return response.data.success;
}

async function resend(): Promise<boolean> {
    let response: AxiosResponse<IApiResponse<any>> = await Vue.axios.get(endpoints.resend);

    return response.data.success;
}

export default {
    checkVerified,
    verify,
    resend,
}
