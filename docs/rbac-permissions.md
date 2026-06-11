# RBAC Permission List

## Roles

- Super Admin
- General Manager
- HR Manager
- Finance Manager
- Warehouse Manager
- Projects Manager
- Dawah Department
- Internal Auditor
- Normal User

## Permission Format

```text
module.screen.action
```

Examples:

- `hr.employees.view`
- `hr.employees.manage`
- `payroll.runs.calculate`
- `payroll.runs.approve`
- `finance.journals.post`
- `documents.documents.upload`
- `audit.logs.view`

Permissions are seeded in `RolesAndPermissionsSeeder`.
