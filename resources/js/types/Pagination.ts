import {ApiResponse} from "./ApiResponse";

export interface PaginationLinks {
    first: string,
    last: string,

    prev: string | null,
    next: string | null,
}

export interface PaginationMeta {
    current_page: number,
    last_page: number,

    from: number,
    to: number,

    per_page: number,
    total: number,

    path: string,
}

export interface Pagination<T> extends ApiResponse<T[]> {
    links: PaginationLinks,
    meta: PaginationMeta,
}
