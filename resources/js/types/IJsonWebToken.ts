export interface IJsonWebToken {
    access_token: string,
    token_type: string,
    expires_at: number,

    is_expired(): boolean,
}
