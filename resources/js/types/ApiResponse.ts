export interface ApiResponse<T> {
    success: boolean,
    data: T,
    messages?: string[],
    error?: string
}
