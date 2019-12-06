import {ApiResponse} from "./ApiResponse";
import {PaginationData} from "./PaginationData";

export interface PaginationResponse<T> extends ApiResponse<PaginationData<T>> {
}
