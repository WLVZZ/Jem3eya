"use client";

import { Area, AreaChart, CartesianGrid, ResponsiveContainer, Tooltip, XAxis, YAxis } from "recharts";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { MetricCard } from "@/components/modules/metric-card";
import { Badge } from "@/components/ui/badge";
import { useLocale } from "@/lib/use-locale";

const chartData = [
  { month: "Jan", payroll: 320, expenses: 410 },
  { month: "Feb", payroll: 335, expenses: 390 },
  { month: "Mar", payroll: 350, expenses: 430 },
  { month: "Apr", payroll: 348, expenses: 420 },
  { month: "May", payroll: 365, expenses: 455 },
  { month: "Jun", payroll: 378, expenses: 470 }
];

export default function DashboardPage() {
  const locale = useLocale();
  const ar = locale === "ar";

  return (
    <div className="space-y-6">
      <div className="flex flex-wrap items-center justify-between gap-3">
        <div>
          <h1 className="text-2xl font-bold">{ar ? "لوحة التحكم التنفيذية" : "Executive Dashboard"}</h1>
          <p className="text-sm text-muted-foreground">
            {ar ? "مؤشرات الموارد والمالية والمشاريع والمخازن" : "HR, finance, projects, and inventory KPIs"}
          </p>
        </div>
        <Badge variant="warning">{ar ? "بيانات تجريبية حتى ربط API" : "Sample data until API binding"}</Badge>
      </div>

      <section className="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <MetricCard label={ar ? "الموظفون" : "Employees"} value="248" trend="+3" />
        <MetricCard label={ar ? "إجمالي المرتبات" : "Payroll Total"} value="378,000 LYD" />
        <MetricCard label={ar ? "المشاريع النشطة" : "Active Projects"} value="41" />
        <MetricCard label={ar ? "مواد منخفضة المخزون" : "Low Stock Items"} value="12" />
      </section>

      <section className="grid gap-4 lg:grid-cols-[1.5fr_1fr]">
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "اتجاه المصروفات والمرتبات" : "Payroll and Expenses Trend"}</CardTitle>
          </CardHeader>
          <CardContent className="h-80">
            <ResponsiveContainer width="100%" height="100%">
              <AreaChart data={chartData}>
                <defs>
                  <linearGradient id="payroll" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="5%" stopColor="hsl(var(--primary))" stopOpacity={0.35} />
                    <stop offset="95%" stopColor="hsl(var(--primary))" stopOpacity={0} />
                  </linearGradient>
                  <linearGradient id="expenses" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="5%" stopColor="hsl(var(--accent))" stopOpacity={0.35} />
                    <stop offset="95%" stopColor="hsl(var(--accent))" stopOpacity={0} />
                  </linearGradient>
                </defs>
                <CartesianGrid strokeDasharray="3 3" stroke="hsl(var(--border))" />
                <XAxis dataKey="month" />
                <YAxis />
                <Tooltip />
                <Area dataKey="payroll" stroke="hsl(var(--primary))" fill="url(#payroll)" />
                <Area dataKey="expenses" stroke="hsl(var(--accent))" fill="url(#expenses)" />
              </AreaChart>
            </ResponsiveContainer>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle>{ar ? "تنبيهات تحتاج إجراء" : "Action Alerts"}</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            {[
              ar ? "اعتماد مسير رواتب يونيو" : "Approve June payroll",
              ar ? "مستندات عقود قاربت الانتهاء" : "Contracts expiring soon",
              ar ? "مشروع تجاوز 80% من الميزانية" : "Project budget above 80%",
              ar ? "مراجعة قيود محاسبية غير مرحلة" : "Review unposted journals"
            ].map((item) => (
              <div key={item} className="rounded-md border p-3 text-sm font-medium">{item}</div>
            ))}
          </CardContent>
        </Card>
      </section>
    </div>
  );
}
