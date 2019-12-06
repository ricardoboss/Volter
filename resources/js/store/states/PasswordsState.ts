import {Password} from "../../types/Password";
import {PaginationData} from "../../types/PaginationData";

export interface PasswordsState {
    passwords: Map<string, Password>,
    latestPagination: PaginationData<Password> | null,
}
