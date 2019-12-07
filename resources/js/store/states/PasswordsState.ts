import {Password} from "../../types/Password";
import {PaginationLinks, PaginationMeta} from "../../types/Pagination";

export interface PasswordsState {
    fetched: { [id: string]: Password; },
    meta: PaginationMeta | null,
    links: PaginationLinks | null,
}
