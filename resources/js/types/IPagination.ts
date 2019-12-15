import {IApiResponse} from "./IApiResponse";

export interface IPaginationLinks {
    first: string,
    last: string,

    prev: string | null,
    next: string | null,
}

export interface IPaginationMeta {
    current_page: number,
    last_page: number,

    from: number,
    to: number,

    per_page: number,
    total: number,

    path: string,
}

export interface IPagination<T> extends IApiResponse<T[]> {
    links: IPaginationLinks,
    meta: IPaginationMeta,
}
