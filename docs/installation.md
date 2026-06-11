# Installation

## Docker

```bash
docker compose up --build
```

The backend container installs Composer packages, generates an app key, runs migrations, and seeds core data.

## Manual Backend

Requires PHP 8.4, Composer, PostgreSQL, Redis, MinIO.

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Manual Frontend

Requires Node.js 24+.

```bash
cd frontend
cp .env.example .env.local
npm install
npm run dev
```
