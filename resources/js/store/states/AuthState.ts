import {User} from "../../types/User";
import {JsonWebToken} from "../../types/JsonWebToken";

export interface AuthState {
    token: JsonWebToken | null,
    user: User | null,
}
