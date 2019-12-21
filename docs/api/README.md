# Volter Docs - API

1. [Overview](#overview)
    1. [Syntax](#syntax)
        1. [Requests](#requests)
        2. [Responses](#responses)
        3. [Variables](#variables)
    2. [Testing](#testing)
2. [Authentication](#authentication)
    1. [Login](#login)
    2. [Logout](#logout)
    3. [Refresh](#refresh)
    4. [Authenticated User Information](#authenticated-user-information)
3. [Users](#users)
    1. [List](#list-users)
    2. [Create](#create-users)
    3. [Modify](#modify-users)
    4. [Delete](#delete-users)
4. [Passwords](#passwords)
    1. [List](#list-passwords)
    2. [Create](#create-passwords)
    3. [Modify](#modify-passwords)
    4. [Delete](#delete-passwords)
    5. [Force Delete](#force-delete-passwords)

## Overview

### Syntax

#### Requests

API Endpoints are documented in the same way as PhpStorm's `.http` files are made up.
The first line is the HTTP method to use followed by the request url.
The lines afterwards make up the HTTP headers to send within the request.

After a blank line follows the request body. This can be anything valid for a HTTP
request such as JSON or a query string.

> Remember to set the `Content-Type` header accordingly if you send a request with a body.

#### Responses

Responses are typically in JSON. Every JSON response can contains the following fields:

```json
{
  "success": false,
  "data": {
    "message": "Unauthenticated."
  }
}
```

* `success`: whether or not the request was successfully processed.
* `data`: contains the actual data for the request. Can be null for failed requests.

It is also possible that there are more keys at the top level of the JSON response.
They are usually meta-data for the response such as `meta` and `links` for pagination.

The response code is also important for handling errors.
The response above for example has response code `401 Unauthorized`.

#### Variables

Variables are documented by enclosing the name of the variable with two paris of curly braces: `{{var_name}}`.
They can appear anywhere in the request: as a header value, in the URL or in the body.
Most of the time, the type of the variable can be derived from the name and context it is used in.
The default type is `string`.

### Testing

**If you are using PhpStorm 2019.3 or later**, you can use the files ending with `.http` for testing.
PhpStorm lets you execute the files directly in the editor with it's built-in HTTP client.
By pressing `alt + enter` while the cursor is in the url, you can select which environment to use.
The environments are stored in the `http-client.env.json` file.
For private variables you can copy the file `http-client.private.env.example.json` to `http-client.private.env.json` and update the values.
It will automatically be ignored by git.

If you now execute a request within PhpStorm from a `.http` file, the included tests are automatically executed and evaluated.

**For testing without PhpStorm**, you can use any generic API testing utility.
We recommend using [Postman](https://www.getpostman.com/) for this.
A collection for Postman is being considered, but not in the works yet.

## Authentication

See file `auth.http`. Use these endpoints to authenticate yourself with Volter.

### Login

```
POST /api/auth/login
Accept: application/json
Content-Type: application/x-www-form-urlencoded

email={{email}}&password={{password}}
```

Result:

```json
{
  "success": true,
  "data": {
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1Ni...",
    "token_type": "bearer",
    "expires_at": 1576900183
  }
}
```

### Logout

```
POST /api/auth/logout
Accept: application/json
Authorization: Bearer {{access_token}}
```

Result:

```json
{
  "success": true,
  "data": null
}
```

### Refresh

```
GET /api/auth/refresh
Accept: application/json
Authorization: Bearer {{access_token}}
```

Result is the same as for the `/api/auth/login` request.

### Authenticated User Information

```
GET /api/auth/me
Accept: application/json
Authorization: Bearer {{access_token}}
```

Result:

```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Ricardo Boss",
    "email": "r@b"
  }
}
```

## Users

See file `users.http`. You can manage users using the API.

### List Users

### Create Users

### Modify Users

### Delete Users

## Passwords

See file `passwords.http`. Passwords can be managed using the API.

### List Passwords

```
GET /api/passwords
Accept: application/json
Authorization: bearer {{access_token}}
```

Result:
```json
{
    "data": [
        {
            "id": "0063465f-a0e8-4dab-9383-98e33cd982a3",
            "version": 0,
            "name": "Server ABC",
            "notes": "",
            "created_at": "2019-12-06 10:05:46",
            "created_by": 1,
            "updated_at": "2019-12-18 12:35:20",
            "updated_by": 3,
            "deleted_at": null,
            "deleted_by": null
        }
    ],
    "links": {
        "first": "host/api/passwords?page=1",
        "last": "host/api/passwords?page=4",
        "prev": null,
        "next": "host/api/passwords?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 4,
        "path": "host/api/passwords",
        "per_page": 15,
        "to": 15,
        "total": 50
    }
}
```

### Create Passwords

### Modify Passwords

### Delete Passwords

### Force Delete Passwords
