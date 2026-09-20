# Budgeter 2026 (Laravel API)

Laravel API backend for the Budgeter 2026 app.

- Backend repo: `https://github.com/dgloriaweb/Budgeter_l13`
- Roadmap: `budgeter_roadmap.md`

## Associated Frontend

- Repository: `https://github.com/dgloriaweb/budgeter2026_vue3`
- Live site: `https://budgeter2026.netlify.app/`

## Current flow (source of truth)

- **Runtime**: Docker via Laravel Sail (`compose.yaml`)
- **Auth**: Sanctum personal access tokens (Bearer tokens)
- **Docs**: Scribe (HTML docs + Postman collection)
- **DB**: MySQL in Docker (`mysql` service)
- **DB UI**: phpMyAdmin (`phpmyadmin` service)

## Local setup

Start containers:

```bash
./vendor/bin/sail up -d
```

### Ports (default)
- API base URL: `http://127.0.0.1:8081`
- MySQL (host access): `127.0.0.1:3308` (see `FORWARD_DB_PORT` in `.env`)
- phpMyAdmin: `http://127.0.0.1:8082/phpmyadmin/` (and `http://127.0.0.1:8082/` redirects there)

### Cache clearing (Laravel)
When routes/config seem “stuck”:

```bash
./vendor/bin/sail artisan optimize:clear
```

### Migrations

```bash
./vendor/bin/sail artisan migrate
```

### API docs + Postman collection (Scribe)

```bash
./vendor/bin/sail artisan scribe:generate
```

Outputs:
- Postman collection: `storage/app/private/scribe/collection.json`
- OpenAPI: `storage/app/private/scribe/openapi.yaml`

Docs UI is served by the app at `/docs` (the link printed by Scribe uses `APP_URL`).

## API endpoints

### Public
- `GET /api/healthcheck`
- `POST /api/register` → `{ success, user, token }`
- `POST /api/login` → `{ success, user, token }`
- `POST /api/auth` → `{ success, user, token }` (alias endpoint for docs/Postman)

### Protected (Bearer token)
Send header: `Authorization: Bearer <token>`

- `GET /api/user`
- `POST /api/logout`
- `GET /api/expenses`

## Database conventions (important)

- We use **singular** table naming for expenses: `expense` (not `expenses`).
- `GET /api/expenses` is scoped by `expense.user_id` to the authenticated user.

## phpMyAdmin login

- URL: `http://127.0.0.1:8082/phpmyadmin/`
- Server/host: `mysql`
- Username: `sail`
- Password: `password` (from `.env`)

## Production notes

After deploy, clear caches so route/config changes take effect:

```bash
php artisan optimize:clear
```
