# API Overview

Base URL:

```text
/api/v1
```

## Auth

- `POST /auth/login`
- `POST /auth/refresh`
- `GET /auth/me`
- `POST /auth/logout`

## Phase 1 Modules

- `GET /dashboard/kpis`
- `GET|POST|PUT|DELETE /employees`
- `GET|POST /payroll/runs`
- `POST /payroll/runs/{id}/calculate`
- `POST /payroll/runs/{id}/approve`
- `POST /payroll/runs/{id}/close`
- `GET|POST /finance/accounts`
- `GET /finance/journal-entries`
- `GET|POST /inventory/items`
- `GET|POST|PUT|DELETE /projects`
- `GET|POST /documents`

## API Docs Roadmap

- Add OpenAPI generation.
- Publish Swagger UI.
- Add schema examples per module.
