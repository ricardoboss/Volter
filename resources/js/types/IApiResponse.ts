export interface IApiResponse<T> {
    success: boolean,
    data: T,
    messages?: string[],
    error?: string
}
