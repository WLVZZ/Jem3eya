# Database Setup

## Required Services

- PostgreSQL 17.
- Redis 7.
- MinIO-compatible S3 storage.

## Core Tables

The migration creates Phase 1 tables for:

- Auth/RBAC/audit.
- HR, contracts, attendance, leave, personnel actions.
- Payroll, loans, legal rule versions.
- Finance and accounting.
- Inventory, purchasing.
- Fixed assets.
- Projects and cost centers.
- Documents and notifications.

## Migration

```bash
cd backend
php artisan migrate --seed
```
