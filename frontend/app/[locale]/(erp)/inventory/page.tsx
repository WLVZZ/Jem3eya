"use client";

import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { DataTable } from "@/components/modules/data-table";
import { useLocale } from "@/lib/use-locale";

const items = [
  { code: "ITM-001", name: "Paper A4", uom: "Box", qty: "24" },
  { code: "ITM-002", name: "جهاز حاسب", uom: "Unit", qty: "5" },
  { code: "ITM-003", name: "مواد دعوية", uom: "Pack", qty: "8" }
];

export default function InventoryPage() {
  const ar = useLocale() === "ar";

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-2xl font-bold">{ar ? "المخازن والأصناف" : "Inventory and Warehouses"}</h1>
        <p className="text-sm text-muted-foreground">
          {ar ? "أصناف، باركود، تحويلات، جرد وتنبيهات نقص" : "Items, barcode, transfers, counts, low-stock alerts"}
        </p>
      </div>

      <section className="grid gap-4 xl:grid-cols-[360px_1fr]">
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "صنف جديد" : "New Item"}</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            <Input placeholder={ar ? "كود الصنف" : "Item code"} />
            <Input placeholder={ar ? "الباركود" : "Barcode"} />
            <Input placeholder={ar ? "اسم الصنف" : "Item name"} />
            <Input placeholder={ar ? "وحدة القياس" : "Unit of measure"} />
            <Button className="w-full">{ar ? "حفظ الصنف" : "Save Item"}</Button>
          </CardContent>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "رصيد المخزون" : "Stock Balance"}</CardTitle>
          </CardHeader>
          <CardContent>
            <DataTable
              rows={items}
              columns={[
                { key: "code", label: ar ? "الكود" : "Code" },
                { key: "name", label: ar ? "الصنف" : "Item" },
                { key: "uom", label: ar ? "الوحدة" : "UOM" },
                { key: "qty", label: ar ? "الكمية" : "Qty" }
              ]}
            />
          </CardContent>
        </Card>
      </section>
    </div>
  );
}
