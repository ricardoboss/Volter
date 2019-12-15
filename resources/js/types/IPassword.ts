import IUser from "./IUser";

export default interface IPassword extends Object {
    id: string,
    version: number,
    name: string,
    notes: string,
    value?: string,
    created_at: Date | null,
    created_by: IUser | null,
    updated_at: Date | null,
    updated_by: IUser | null,
    deleted_at: Date | null,
    deleted_by: IUser | null,
}
