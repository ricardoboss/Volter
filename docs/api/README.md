# Volter Docs - API

1. [Authentication](#authentication)

## Authentication

See file `auth.http`.

### Login

```http request
POST http://{{host}}/api/auth/login
Accept: application/json
Content-Type: application/x-www-form-urlencoded

email={{email}}&password={{password}}
```

### 
