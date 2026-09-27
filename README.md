# Budgeter 2026 (Laravel API)

Laravel API backend for the Budgeter 2026 app.

- Backend repo: `https://github.com/dgloriaweb/Budgeter_l13`
- url to project on Digitalocean: cd /var/www/html/Budgeter_l13/

## Associated Frontend

- Repository: `https://github.com/dgloriaweb/budgeter2026_vue3`
- Live site: `https://budgeterfrontend2026.netlify.app`

### Ports (default)

- API base URL: `http://127.0.0.1:8000` or https://dgloriaapi.co.uk/api/healthcheck
- MySQL (host access): `127.0.0.1:3308` (see `FORWARD_DB_PORT` in `.env`)
- phpMyAdmin: `http://localhost/phpmyadmin`

## API endpoints

- `GET /api/healthcheck`
- `POST /api/register` → `{ success, user, token }`
- `POST /api/login` → `{ success, user, token }`
- `POST /api/auth` → `{ success, user, token }` (alias endpoint for docs/Postman)

### API docs + Postman collection (Scribe)

```bash
php artisan scribe:generate
```

Outputs:

- Postman collection: `storage/app/private/scribe/collection.json`
- OpenAPI: `storage/app/private/scribe/openapi.yaml`

Docs UI is served by the app at `/docs` (the link printed by Scribe uses `APP_URL`).

## Production notes

After deploy, clear caches so route/config changes take effect:

```bash
php artisan optimize:clear
```
