import {User} from "./User";

export interface Password {
    id: string,
    version: number,
    name: string,
    notes: string,
    value?: string,
    created_at: Date,
    created_by: number | User,
    updated_at: Date,
    updated_by: number | User,
    deleted_at: Date,
    deleted_by: number | User,
}
