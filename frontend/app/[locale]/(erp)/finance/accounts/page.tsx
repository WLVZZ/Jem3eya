"use client";

import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Select } from "@/components/ui/select";
import { DataTable } from "@/components/modules/data-table";
import { useLocale } from "@/lib/use-locale";

const accounts = [
  { code: "1000", name: "الأصول", type: "asset", balance: "debit" },
  { code: "2000", name: "الالتزامات", type: "liability", balance: "credit" },
  { code: "5000", name: "المصروفات", type: "expense", balance: "debit" }
];

export default function AccountsPage() {
  const ar = useLocale() === "ar";

  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-2xl font-bold">{ar ? "شجرة الحسابات" : "Chart of Accounts"}</h1>
        <p className="text-sm text-muted-foreground">
          {ar ? "شجرة غير محدودة مع مراكز تكلفة للمشاريع" : "Unlimited tree with project cost centers"}
        </p>
      </div>

      <section className="grid gap-4 xl:grid-cols-[360px_1fr]">
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "حساب جديد" : "New Account"}</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            <Input placeholder={ar ? "الكود" : "Code"} />
            <Input placeholder={ar ? "الاسم العربي" : "Arabic name"} />
            <Input placeholder={ar ? "الاسم الإنجليزي" : "English name"} />
            <Select>
              <option value="asset">{ar ? "أصل" : "Asset"}</option>
              <option value="liability">{ar ? "التزام" : "Liability"}</option>
              <option value="equity">{ar ? "حقوق / أموال" : "Equity/Fund"}</option>
              <option value="revenue">{ar ? "إيراد" : "Revenue"}</option>
              <option value="expense">{ar ? "مصروف" : "Expense"}</option>
            </Select>
            <Button className="w-full">{ar ? "حفظ الحساب" : "Save Account"}</Button>
          </CardContent>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle>{ar ? "الحسابات الرئيسية" : "Primary Accounts"}</CardTitle>
          </CardHeader>
          <CardContent>
            <DataTable
              rows={accounts}
              columns={[
                { key: "code", label: ar ? "الكود" : "Code" },
                { key: "name", label: ar ? "الاسم" : "Name" },
                { key: "type", label: ar ? "النوع" : "Type" },
                { key: "balance", label: ar ? "طبيعة الرصيد" : "Balance" }
              ]}
            />
          </CardContent>
        </Card>
      </section>
    </div>
  );
}
