import {User} from "./User";

export interface Password {
    id: string,
    version: number,
    name: string,
    notes: string,
    value?: string,
    created_at: Date,
    created_by: User | null,
    updated_at: Date,
    updated_by: User | null,
    deleted_at: Date,
    deleted_by: User | null,
}
