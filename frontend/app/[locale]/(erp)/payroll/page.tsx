"use client";

import { Calculator, CheckCircle2, FileText, Lock } from "lucide-react";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Select } from "@/components/ui/select";
import { DataTable } from "@/components/modules/data-table";
import { useLocale } from "@/lib/use-locale";

const steps = [
  { Icon: FileText, labelAr: "مسودة", labelEn: "Draft" },
  { Icon: Calculator, labelAr: "احتساب", labelEn: "Calculate" },
  { Icon: CheckCircle2, labelAr: "اعتماد", labelEn: "Approve" },
  { Icon: Lock, labelAr: "إغلاق", labelEn: "Close" }
];

const rows = [
  { employee: "EMP-001", gross: "1,450", deductions: "0", net: "1,450" },
  { employee: "EMP-002", gross: "1,800", deductions: "0", net: "1,800" }
];

export default function PayrollPage() {
  const ar = useLocale() === "ar";

  return (
    <div className="space-y-6">
      <div className="flex flex-wrap items-center justify-between gap-3">
        <div>
          <h1 className="text-2xl font-bold">{ar ? "دورة المرتبات" : "Payroll Cycle"}</h1>
          <p className="text-sm text-muted-foreground">
            {ar ? "احتساب قانوني قابل للتهيئة والمراجعة" : "Configurable, reviewable legal payroll calculation"}
          </p>
        </div>
        <Badge variant="warning">{ar ? "لا توجد نسب قانونية ثابتة" : "No hard-coded legal rates"}</Badge>
      </div>

      <section className="grid gap-4 xl:grid-cols-[360px_1fr]">
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "إنشاء مسير" : "Create Run"}</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            <Input type="month" />
            <Select>
              <option>{ar ? "كل الفروع" : "All branches"}</option>
            </Select>
            <Select>
              <option>{ar ? "قواعد ليبيا - مسودة مراجعة" : "Libya rules - review draft"}</option>
            </Select>
            <Button className="w-full">{ar ? "إنشاء مسير مبدئي" : "Create Draft Run"}</Button>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle>{ar ? "خطوات الاعتماد" : "Approval Steps"}</CardTitle>
          </CardHeader>
          <CardContent className="grid gap-3 md:grid-cols-4">
            {steps.map(({ Icon, labelAr, labelEn }) => (
              <div key={labelEn} className="rounded-lg border p-4">
                <Icon className="mb-3 h-5 w-5 text-primary" />
                <div className="text-sm font-bold">{ar ? labelAr : labelEn}</div>
              </div>
            ))}
          </CardContent>
        </Card>
      </section>

      <Card>
        <CardHeader>
          <CardTitle>{ar ? "بنود المسير" : "Payroll Items"}</CardTitle>
        </CardHeader>
        <CardContent>
          <DataTable
            rows={rows}
            columns={[
              { key: "employee", label: ar ? "الموظف" : "Employee" },
              { key: "gross", label: ar ? "الإجمالي" : "Gross" },
              { key: "deductions", label: ar ? "الاستقطاعات" : "Deductions" },
              { key: "net", label: ar ? "الصافي" : "Net" }
            ]}
          />
        </CardContent>
      </Card>
    </div>
  );
}
