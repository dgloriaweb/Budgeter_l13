# Budgeter 2026 - Project Roadmap

## Current Setup (Source of truth)
- **Backend**: Laravel API running via Sail.
- **Auth**: Sanctum personal access tokens (Bearer token).
- **Docs**: Scribe generates HTML docs + Postman collection:
  - HTML: `http://localhost:8000/docs`
  - Postman collection: `storage/app/private/scribe/collection.json`
- **Database**: MySQL in Docker (`mysql` service).
  - Host access (from your machine): `127.0.0.1:3308` (see `FORWARD_DB_PORT`)
  - phpMyAdmin: `http://127.0.0.1:8082/` (or `http://127.0.0.1:8082/phpmyadmin/` after container recreate)

## Day-to-day dev flow (what we actually do now)
1. **Start containers**: `./vendor/bin/sail up -d`
2. **Clear Laravel caches (when routes/config change)**: `./vendor/bin/sail artisan optimize:clear`
3. **Run migrations**: `./vendor/bin/sail artisan migrate`
4. **Generate API docs + Postman**: `./vendor/bin/sail artisan scribe:generate`
5. **Test with Postman**
   - `POST /api/register` → `{ user, token }`
   - `POST /api/login` → `{ user, token }`
   - `POST /api/auth` → `{ user, token }` (alias endpoint for docs/Postman)
   - Use `Authorization: Bearer {{auth_token}}` for protected endpoints.

## Phase 1: Frontend Mock Pages & Local State (Vue 3)
1. **Design Account Dashboard View**: Build a clean mobile-first view listing all user accounts and their current balances.
2. **Build Balance Update Form**: Create a quick action flow to update an account balance instantly with zero friction.
3. **Build Bill Entry Form**: Create a simple form interface to log a paid bill (amount, category, date, account used).
4. **Mock Persistence**: Wire these views up to local storage or local JSON structures so the entire user flow can be tested end-to-end without touching the database yet.

## Phase 2: Backend Database & Migration Verification
1. **Inspect DB schema**: Use phpMyAdmin or read-only SQL to confirm table/column reality before writing migrations.
2. **Finalize schema in migrations (minimal + safe)**
   - `expense` table is **singular** (we do not follow Laravel plural defaults here).
   - Add missing columns via additive migrations (eg `user_id`) to match API filtering.
   - Avoid creating duplicate tables when legacy tables already exist (eg existing `account` table).

## Phase 3: Core API Endpoint Development (Laravel 13)
1. **Auth API (done)**
   - Public: `POST /api/register`, `POST /api/login`, `POST /api/auth`
   - Protected: `GET /api/user`, `POST /api/logout`
2. **Expenses API (in place)**
   - Protected: `GET /api/expenses` (scoped to authenticated user via `expense.user_id`)
   - Next: `POST /api/expenses` (create one expense row)
3. **Accounts API (next)**
   - Define endpoints that match the existing `account` table shape (currently legacy columns like `account_id`, `account_name`, etc.).
4. **API Documentation (ongoing)**
   - Keep Scribe annotations accurate so Postman stays correct.

## Phase 4: Frontend-to-Backend Integration
1. **Connect API Client**: Swap out local mock storage in the Vue 3 app for real requests.
   - Local dev: call same-origin `/api/...` (Vite dev proxy)
   - Production: set `VITE_API_BASE_URL` (Netlify) to `https://dgloriaapi.co.uk`
2. **End-to-End Testing**: Test checking balances, updating balances, and logging bills from the live frontend to the live server.

## Phase 5: Production Polish & Hardening
1. **Turn Off Debug Mode**: Execute the production command to disable debug on the live environment (`APP_DEBUG=false`).
2. **Deploy + clear caches**: After deploying, run `php artisan optimize:clear` (or equivalent) on the server so routes/config changes take effect.