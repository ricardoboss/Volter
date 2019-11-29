# Volter Docs - API

1. [Overview](#overview)
2. [Authentication](#authentication)

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

Every JSON response has the same markup. Here is an example of a response:

```json
{
  "success": false,
  "result": null,
  "messages": [],
  "errors": [
    "Invalid login credentials."
  ]
}
```

* `success`: whether or not the request was successfully processed.
* `result`: not-null for requests which return data. If `success` is `false`, this is `null` most of the time.
* `messages`: status messages, usually meant for reporting information to the user.
* `errors`: error messages to help debug what went wrong.

## Authentication

See file `auth.http`. Use these endpoints to authenticate yourself with Volter.

### Login

```http request
POST http://{{host}}/api/auth/login
Accept: application/json
Content-Type: application/x-www-form-urlencoded

email={{email}}&password={{password}}
```

### Logout

```http request
POST http://{{host}}/api/auth/logout
Accept: application/json
Authorization: Bearer {{access_token}}
```

### Refresh

```http request
GET http://{{host}}/api/auth/refresh
Accept: application/json
Authorization Bearer {{access_token}}
```

### Authenticated User Information

```http request
GET http://{{host}}/api/auth/me
Accept: application/json
Authorization: Bearer {{access_token}}
```
