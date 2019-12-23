const asciiCharGenerator = function (min: number, max: number, exclude: number[] = []): string {
    let code: number;

    do {
        code = Math.floor(Math.random() * ((max + 1) - min)) + min;
    } while (exclude.includes(code));

    return String.fromCharCode(code);
};

const upgradeRandom = function () {
    // @ts-ignore
    let rng = window.crypto || window.msCrypto;
    if (rng === undefined) {
        console.warn("Browser does not support window.crypto! Falling back to default Math.random.");

        return;
    }

    Math.random = function () {
        return rng.getRandomValues(new Uint32Array(1))[0] / 4294967296;
    };
};

const generate = function (length: number, includeSymbols: boolean = true, includeNumbers: boolean = true, excludeChars: string[] = [], blacklist: string[] = []): string {
    upgradeRandom();

    let password = "";
    let ascii_min = 32;
    let ascii_max = 126;
    let ascii_exclude: number[] = [];

    for (let char of excludeChars) {
        ascii_exclude.push(char.charCodeAt(0));
    }

    if (!includeSymbols) {
        ascii_min = 48; // 0
        ascii_exclude.push(
            58, 59, 60, 61, 62, 63, 64,
            91, 92, 93, 94, 95, 96,
        );
        ascii_max = 122; // z
    }

    if (!includeNumbers) {
        ascii_min = 65; // A
    }

    do {
        for (let i = 0; i < length; i++) {
            password += asciiCharGenerator(ascii_min, ascii_max, ascii_exclude);
        }
    } while (blacklist.includes(password));

    return password;
};

export default {
    generate,
};
