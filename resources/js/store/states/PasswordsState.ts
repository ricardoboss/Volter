import IPassword from "../../types/IPassword";
import {IPaginationLinks, IPaginationMeta} from "../../types/IPagination";

export default interface PasswordsState {
    fetched: { [id: string]: IPassword; },
    meta: IPaginationMeta | null,
    links: IPaginationLinks | null,
}
