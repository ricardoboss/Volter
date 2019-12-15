export default interface IJsonWebToken extends Object {
    access_token: string,
    token_type: string,
    expires_at: number,

    is_expired(): boolean,
}
