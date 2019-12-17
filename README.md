![](https://github.styleci.io/repos/228243964/shield)

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

### Dependency Setup

First, install the composer and node dependencies:

```bash
$ composer install
$ yarn
```

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

Afterwards, run `php artisan key:generate` to generate an `APP_KEY`, which is used to encrypt cookies and sign JWTs.

> Keep in mind that **changing** or **loosing** your `APP_KEY` means that you are unable to decrypt encrypted values.

### API Testing Setup

Copy the file at `docs/api/http-client.private.env.example.json` to `docs/api/http-client.private.env.json` (notice the
lack of `.example` in the new filename).

Now edit the contents of the file to match your `SEED_EMAIL` and `SEED_PASS` settings in your `.env` file.
