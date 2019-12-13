declare module '*.vue' {
    import Vue from 'vue'

    export default Vue
}

declare interface Object {
    pick(keys: string[]): Object;
}
