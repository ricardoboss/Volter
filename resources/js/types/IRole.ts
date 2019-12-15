export default interface IRole extends Object {
    id: number,
    name: string,
    slug: string,
    description: string,
    level: number,
    created_at: Date | null,
    updated_at: Date | null,
    deleted_at: Date | null,
}
