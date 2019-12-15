import {IUser} from "./IUser";

export interface IPassword {
    id: string,
    version: number,
    name: string,
    notes: string,
    value?: string,
    created_at: Date,
    created_by: IUser | null,
    updated_at: Date,
    updated_by: IUser | null,
    deleted_at: Date,
    deleted_by: IUser | null,
}
