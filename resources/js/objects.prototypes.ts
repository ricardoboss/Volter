Object.prototype.pick = function (keys: any[]): Object {
    const obj: { [key: string]: any } = this;

    return Object.keys(obj)
        .filter(k => keys.includes(k))
        .map(k => Object.assign({}, {[k]: obj[k]}))
        .reduce((res, o) => Object.assign(res, o), {})
};
