import {
  Archive,
  Boxes,
  BriefcaseBusiness,
  Calculator,
  Gauge,
  Landmark,
  Users
} from "lucide-react";

export const navigation = [
  { href: "/dashboard", labelKey: "dashboard", icon: Gauge, permission: "dashboard.kpis.view" },
  { href: "/employees", labelKey: "employees", icon: Users, permission: "hr.employees.view" },
  { href: "/payroll", labelKey: "payroll", icon: Calculator, permission: "payroll.runs.view" },
  { href: "/finance/accounts", labelKey: "accounts", icon: Landmark, permission: "finance.accounts.view" },
  { href: "/inventory", labelKey: "inventory", icon: Boxes, permission: "inventory.items.view" },
  { href: "/projects", labelKey: "projects", icon: BriefcaseBusiness, permission: "projects.projects.view" },
  { href: "/documents", labelKey: "documents", icon: Archive, permission: "documents.documents.view" }
] as const;
