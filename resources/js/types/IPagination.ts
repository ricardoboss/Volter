import IApiResponse from "./IApiResponse";

export interface IPaginationLinks extends Object {
    first: string,
    last: string,

    prev: string | null,
    next: string | null,
}

export interface IPaginationMeta extends Object {
    current_page: number,
    last_page: number,

    from: number,
    to: number,

    per_page: number,
    total: number,

    path: string,
}

export default interface IPagination<T> extends IApiResponse<T[]> {
    links: IPaginationLinks,
    meta: IPaginationMeta,
}
