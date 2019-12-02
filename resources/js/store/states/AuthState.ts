import {User} from "../../types/User";
import {JsonWebToken} from "../../types/JsonWebToken";

export interface AuthState {
    loadingUser: boolean,
    token: JsonWebToken | null,
    user: User | null,
}
