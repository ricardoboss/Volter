export interface ApiResponse<T> {
    success: boolean,
    result: T,
    messages?: string[],
    error?: string
}
