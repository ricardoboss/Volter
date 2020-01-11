> # Notice
> This project will not be developed further due to lack of knowledge, time, interest and money. Feel free to create forks and stick to what the license allows you to do (and what not to).

[![](https://img.shields.io/badge/license-GPL3-brightgreen?style=flat-square)](https://github.com/ricardoboss/Volter/blob/master/LICENSE)
[![codecov](https://codecov.io/gh/ricardoboss/Volter/branch/master/graph/badge.svg?token=4vvncRsfFH)](https://codecov.io/gh/ricardoboss/Volter)
[![](https://github.com/ricardoboss/Volter/workflows/Laravel%20CI/badge.svg)](https://github.com/ricardoboss/Volter/actions)

# Volter

Volter (pronounced: _woltr_) is an in-house password storage.

Here you can find information about the structure of Volter.
Whether you need information about the API or some other part of Volter, everything is here.

## Overview

`docs/`
* `api/`:
  The entry point for everything API related.


## Development Environment Setup

Simply follow these steps to set up your local development environment:

### Environment Specific Setup

Copy the `.env.example` file to `.env` in the root directory.
Edit the contents to match your local setup (like `DB_*` values):

```dotenv
APP_NAME=volter
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=volter
DB_USERNAME=volter
DB_PASSWORD=somethingsecure

...

SEED_NAME="Your Name"
SEED_MAIL=you@example.org
SEED_PASS=secure
```

### Dependency Setup

First, install the composer and node dependencies:

```bash
$ composer install
$ yarn
```

Afterwards, run
```bash
$ php artisan key:generate
$ php artisan jwt:secret -f
```

to generate an `APP_KEY` and `JWT_SECRET`, which are used to encrypt cookies and sign JWTs.

> Keep in mind that **changing** or **loosing** your `APP_KEY` means that you are unable to decrypt encrypted values.
> Losing `JWT_SECRET` only invalidates all tokens, which is like logging all users out at once.

### API Testing Setup

Copy the file at `docs/api/http-client.private.env.example.json` to `docs/api/http-client.private.env.json` (notice the
lack of `.example` in the new filename).

Now edit the contents of the file to match your `SEED_EMAIL` and `SEED_PASS` settings in your `.env` file.
