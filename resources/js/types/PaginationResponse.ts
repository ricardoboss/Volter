import {ApiResponse} from "./ApiResponse";

export interface PaginationResponse<T> extends ApiResponse<PaginationData<T>> {
}

export interface PaginationData<T> extends Record<string, string> {

}
