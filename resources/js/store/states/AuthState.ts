import IUser from "../../types/IUser";
import IJsonWebToken from "../../types/IJsonWebToken";

export default interface AuthState {
    token: IJsonWebToken | null,
    user: IUser | null,
}
