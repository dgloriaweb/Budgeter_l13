# Budgeter v 2026

Github repo: https://github.com/dgloriaweb/Budgeter_l13

Laravel 13 backend API for the Budgeter application.

## Associated Frontend

- Repository: https://github.com/dgloriaweb/budgeter2026_vue3
- Live Site: https://budgeter2026.netlify.app/

## Project Outline

Provide api backend endpoints to store and manipulate data for Budgeter 2026 app

### How

Updates: git pull inside digitalocean terminal

```bash
cd /var/www/Budgeter_l13
```

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
[ ] Set up ssh on server

Start creating endpoints
[ ] Create basic API health check endpoint (/api/health)
[ ] Test endpoints using Postman

### before release

[ ] Turn off debug on live

```bash
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env && docker exec -it budgeter_l13-laravel.test-1 php artisan config:clear
```
