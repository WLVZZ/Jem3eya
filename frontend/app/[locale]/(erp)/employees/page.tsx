"use client";

import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Select } from "@/components/ui/select";
import { DataTable } from "@/components/modules/data-table";
import { useLocale } from "@/lib/use-locale";

const employees = [
  { no: "EMP-001", name: "أحمد السنوسي", department: "الموارد البشرية", status: "active" },
  { no: "EMP-002", name: "Mariam Ali", department: "Finance", status: "active" },
  { no: "EMP-003", name: "سالم الترهوني", department: "المشاريع", status: "suspended" }
];

export default function EmployeesPage() {
  const ar = useLocale() === "ar";

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-2xl font-bold">{ar ? "الموظفون" : "Employees"}</h1>
        <p className="text-sm text-muted-foreground">
          {ar ? "ملفات الموظفين والعقود والمستندات" : "Employee profiles, contracts, and documents"}
        </p>
      </div>

      <section className="grid gap-4 xl:grid-cols-[360px_1fr]">
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "بيانات موظف" : "Employee Form"}</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            <Input placeholder={ar ? "الرقم الوظيفي" : "Employee number"} />
            <Input placeholder={ar ? "الاسم العربي الكامل" : "Full Arabic name"} />
            <Input placeholder={ar ? "الاسم الإنجليزي" : "Full English name"} />
            <Input placeholder={ar ? "الرقم الوطني" : "National ID"} />
            <Select>
              <option>{ar ? "دائم" : "Permanent"}</option>
              <option>{ar ? "مؤقت" : "Temporary"}</option>
              <option>{ar ? "عقد تعاون" : "Cooperation"}</option>
              <option>{ar ? "عقد خبير" : "Expert"}</option>
            </Select>
            <Button className="w-full">{ar ? "حفظ الموظف" : "Save Employee"}</Button>
          </CardContent>
        </Card>

        <Card>
          <CardHeader className="flex-row items-center justify-between">
            <CardTitle>{ar ? "سجل الموظفين" : "Employee Register"}</CardTitle>
            <Input className="max-w-xs" placeholder={ar ? "بحث" : "Search"} />
          </CardHeader>
          <CardContent>
            <DataTable
              rows={employees}
              columns={[
                { key: "no", label: ar ? "الرقم" : "No." },
                { key: "name", label: ar ? "الاسم" : "Name" },
                { key: "department", label: ar ? "القسم" : "Department" },
                { key: "status", label: ar ? "الحالة" : "Status" }
              ]}
            />
          </CardContent>
        </Card>
      </section>
    </div>
  );
}
