# Budgeter v 2026

## Budgeter 2026 - Project Roadmap

### Phase 1: Frontend Mock Pages & Local State (Vue 3)

1. **Design Account Dashboard View**: Build a clean mobile-first view listing all user accounts and their current balances.
2. **Build Balance Update Form**: Create a quick action flow to update an account balance instantly with zero friction.
3. **Build Bill Entry Form**: Create a simple form interface to log a paid bill (amount, category, date, account used).
4. **Mock Persistence**: Wire these views up to local storage or local JSON structures so the entire user flow can be tested end-to-end without touching the database yet.

### Phase 2: Backend Database & Migration Verification

1. **Inspect Live Database**: Run artisan commands on the droplet to check existing migration tables (`accounts`, `bills`).
2. **Finalize Database Schema**: Write or verify Laravel migrations for `accounts` and `bills` tables to match the exact fields required by the frontend mocks.

### Phase 3: Core API Endpoint Development (Laravel 13)

1. **Accounts API**: Build controllers and routes for fetching all accounts and updating an account balance.
2. **Bills API**: Build controllers and routes for storing newly paid bills.
3. **API Documentation**: Update Scribe annotations to document the new endpoints cleanly.

### Phase 4: Frontend-to-Backend Integration

1. **Connect API Client**: Swap out local mock storage in the Vue 3 app for real Axios requests pointing to `http://dgloriaapi.co.uk:8081/api`.
2. **End-to-End Testing**: Test checking balances, updating balances, and logging bills from the live frontend to the live server.

### Phase 5: Production Polish & Hardening

1. **Turn Off Debug Mode**: Execute the production command to disable debug on the live environment (`APP_DEBUG=false`).
2. **Final Deployment Run**: Push updates to GitHub and run the automated production deployment script on the DigitalOcean droplet.

Github repo: https://github.com/dgloriaweb/Budgeter_l13

Laravel 13 backend API for the Budgeter application.

## Associated Frontend

- Repository: https://github.com/dgloriaweb/budgeter2026_vue3
- Live Site: https://budgeter2026.netlify.app/

## Project Outline

Provide api backend endpoints to store and manipulate data for Budgeter 2026 app

### Where

This app runs on digitalocean lamp docker ubuntu v24 - noble

### Why

Need a stable, reliable, safe backend that provides middleware, routing and endpoint to store data.
Using docker helps to avoid constant updating of developing environment if the development has to be suspended for a term.

### When

Starting Aug 2026 based on previous experience. Plan is to finish asap, but with no errors and testing mostly security rather than data.

## Local Environment & Setup

- Docker environment running via Laravel Sail
- Certificates: letsencrypt. Renew: certbot renew

### Daily Management

1.  Startup
    Start Docker containers: ./vendor/bin/sail up -d
    Opens: Local API URL: http://localhost:8081

    Database Port: 3308

2.  Stop Docker containers
    ./vendor/bin/sail down

3.  Create api docs
    sail artisan scribe:generate

## Current Status & Tasks

Create a new Git branch before starting any development

### Tasks to do

Verify DigitalOcean deployment and ensure updates work via git pull in the DigitalOcean terminal
[x] Check if DigitalOcean server is running
[x] Set up ssh on server

Start creating endpoints
[x] Create basic API health check endpoint (/api/health)
[x] Test endpoints using Postman

### before release

[ ] Turn off debug on live

```bash
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env && docker exec -it budgeter_l13-laravel.test-1 php artisan config:clear
```

## Installing new package locally and apply on live

### install package

```bash
sail composer require vendor/package-name
```

### update composer

```bash
git add composer.json composer.lock
git commit -m "chore: install vendor/package-name"
git push origin main
```

### pull and install on production

```bash
#!/usr/bin/env bash
set -e

echo "🚀 Starting Deployment..."

# 1. Pull latest code from main
git pull origin main

# 2. Install production PHP dependencies (no dev packages)
sail composer install --no-dev --optimize-autoloader

# 3. Safe Migration: Applies ONLY new pending migration files (preserves existing data)
sail artisan migrate --force

# 4. Clear and rebuild optimized caches (Laravel production command)
sail artisan optimize

# 5. Regenerate API documentation & Postman collections
sail artisan scribe:generate

echo "✅ Deployment Successful!"
```

## Droplet usage

On droplet restart:

```bash
cd /var/www/Budgeter_l13
sail up -d
```

Updates: git pull inside digitalocean terminal

```bash
cd /var/www/Budgeter_l13
```
