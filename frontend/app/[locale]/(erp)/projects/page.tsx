"use client";

import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Select } from "@/components/ui/select";
import { DataTable } from "@/components/modules/data-table";
import { useLocale } from "@/lib/use-locale";

const projects = [
  { code: "PRJ-001", name: "مسجد", type: "mosques", progress: "62%" },
  { code: "PRJ-002", name: "Education Program", type: "education", progress: "31%" },
  { code: "PRJ-003", name: "كفالة أيتام", type: "orphan", progress: "84%" }
];

export default function ProjectsPage() {
  const ar = useLocale() === "ar";

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-2xl font-bold">{ar ? "المشاريع والدعوة" : "Dawah and Projects"}</h1>
        <p className="text-sm text-muted-foreground">
          {ar ? "ميزانيات، مانحون، مستندات وربط مراكز تكلفة" : "Budgets, donors, documents, and cost centers"}
        </p>
      </div>

      <section className="grid gap-4 xl:grid-cols-[360px_1fr]">
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "مشروع جديد" : "New Project"}</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            <Input placeholder={ar ? "كود المشروع" : "Project code"} />
            <Input placeholder={ar ? "اسم المشروع" : "Project name"} />
            <Select>
              <option>{ar ? "مساجد" : "Mosques"}</option>
              <option>{ar ? "مدارس" : "Schools"}</option>
              <option>{ar ? "مراكز إسلامية" : "Islamic centers"}</option>
              <option>{ar ? "إغاثة" : "Relief"}</option>
              <option>{ar ? "كفالة أيتام" : "Orphan sponsorship"}</option>
            </Select>
            <Input placeholder={ar ? "الميزانية" : "Budget"} />
            <Button className="w-full">{ar ? "حفظ المشروع" : "Save Project"}</Button>
          </CardContent>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "المشاريع النشطة" : "Active Projects"}</CardTitle>
          </CardHeader>
          <CardContent>
            <DataTable
              rows={projects}
              columns={[
                { key: "code", label: ar ? "الكود" : "Code" },
                { key: "name", label: ar ? "الاسم" : "Name" },
                { key: "type", label: ar ? "النوع" : "Type" },
                { key: "progress", label: ar ? "الإنجاز" : "Progress" }
              ]}
            />
          </CardContent>
        </Card>
      </section>
    </div>
  );
}
