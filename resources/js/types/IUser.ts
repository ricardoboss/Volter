import IRole from "./IRole";
import IPermission from "./IPermission";

export default interface IUser extends Object {
    id: number,
    name: string,
    email: string,
    roles?: IRole[],
    permissions?: IPermission[],
}
