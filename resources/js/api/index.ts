import auth from "./auth";
import email from "./email";
import passwords from "./passwords";

export function inject(url: string, queryParams: {[id: string]: string}) {
    if (queryParams === null)
        return url;

    let params = new URLSearchParams();

    Object.keys(queryParams).forEach(key => {
        if (url.indexOf("{" + key + "}") >= 0)
            url = url.replace("{" + key + "}", queryParams[key]);
        else
            params.append(key, queryParams[key]);
    });

    if (params.toString().length > 0)
        url += "?" + params.toString();

    return url;
}

export default {
    auth,
    passwords,
    email,
}
