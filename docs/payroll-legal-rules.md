# Payroll Legal Rules

The payroll foundation supports Libyan legal review requirements without hard-coded rates.

## References Tracked

- Libyan Labour Relations Law No. 12 of 2010.
- Libyan Income Tax Law No. 7 of 2010.
- Salary/payroll regulations for national employees.

## Rule Versioning

Rules live in `legal_rule_versions`.

Each version stores:

- Jurisdiction.
- Effective dates.
- Approval status.
- JSON rule payload.
- Reviewer/approval metadata.

## Critical Rule

Tax, insurance, allowances, salary scales, holds, loans, and garnishments must be configured by an authorized admin after legal/accounting review.

Seeded legal rates are intentionally zero.
