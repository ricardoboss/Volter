export default interface IApiResponse<T> extends Object {
    success: boolean,
    data: T,
}
