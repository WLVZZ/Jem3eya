"use client";

import { Upload } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Select } from "@/components/ui/select";
import { DataTable } from "@/components/modules/data-table";
import { useLocale } from "@/lib/use-locale";

const docs = [
  { title: "عقد موظف", category: "HR", version: "1", expires: "2026-12-31" },
  { title: "Supplier Invoice", category: "Finance", version: "2", expires: "-" },
  { title: "Project Report", category: "Projects", version: "1", expires: "-" }
];

export default function DocumentsPage() {
  const ar = useLocale() === "ar";

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-2xl font-bold">{ar ? "المستندات والأرشفة" : "Documents and Archiving"}</h1>
        <p className="text-sm text-muted-foreground">
          {ar ? "إصدارات، صلاحيات، OCR جاهز وربط بالسجلات" : "Versioning, permissions, OCR-ready, linked records"}
        </p>
      </div>

      <section className="grid gap-4 xl:grid-cols-[360px_1fr]">
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "رفع مستند" : "Upload Document"}</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            <Input placeholder={ar ? "العنوان العربي" : "Arabic title"} />
            <Select>
              <option>HR</option>
              <option>Finance</option>
              <option>Projects</option>
              <option>Assets</option>
            </Select>
            <Input type="file" />
            <Button className="w-full">
              <Upload className="h-4 w-4" />
              {ar ? "رفع" : "Upload"}
            </Button>
          </CardContent>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "الأرشيف" : "Archive"}</CardTitle>
          </CardHeader>
          <CardContent>
            <DataTable
              rows={docs}
              columns={[
                { key: "title", label: ar ? "العنوان" : "Title" },
                { key: "category", label: ar ? "التصنيف" : "Category" },
                { key: "version", label: ar ? "الإصدار" : "Version" },
                { key: "expires", label: ar ? "ينتهي" : "Expires" }
              ]}
            />
          </CardContent>
        </Card>
      </section>
    </div>
  );
}
