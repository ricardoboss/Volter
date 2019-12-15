import {IJsonWebToken} from "./IJsonWebToken";

export class JsonWebToken implements IJsonWebToken {
    access_token: string;
    expires_at: number;
    token_type: string;

    public constructor(token: IJsonWebToken);
    public constructor(access_token: string, token_type: string, expires_at: number);

    public constructor(token: string | IJsonWebToken, token_type?: string, expires_at?: number) {
        if (token instanceof String) {
            this.access_token = token as string;

            if (token_type === null)
                throw new Error("token_type cannot be null!");

            this.token_type = token_type as string;

            if (expires_at === null)
                throw new Error("expires_at cannot be null!");

            this.expires_at = expires_at as number;
        } else {
            const other: IJsonWebToken = token as IJsonWebToken;

            this.access_token = other.access_token;
            this.token_type = other.token_type;
            this.expires_at = other.expires_at;
        }
    }

    public is_expired(): boolean {
        return this.expires_at <= Math.floor((new Date).getTime() / 1000);
    }
}
