import {IPassword} from "../../types/IPassword";
import {IPaginationLinks, IPaginationMeta} from "../../types/IPagination";

export interface PasswordsState {
    fetched: { [id: string]: IPassword; },
    meta: IPaginationMeta | null,
    links: IPaginationLinks | null,
}
