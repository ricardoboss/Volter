import {IUser} from "../../types/IUser";
import {IJsonWebToken} from "../../types/IJsonWebToken";

export interface AuthState {
    token: IJsonWebToken | null,
    user: IUser | null,
}
