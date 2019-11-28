import {User} from "../../types/User";

export interface AuthState {
    token: string | null,
    user: User | null,
}
