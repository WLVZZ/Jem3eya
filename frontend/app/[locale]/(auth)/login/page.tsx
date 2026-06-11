"use client";

import { FormEvent, useState } from "react";
import { useRouter } from "next/navigation";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { login } from "@/lib/api";
import { dictionaries, t } from "@/lib/i18n";
import { useLocale } from "@/lib/use-locale";

export default function LoginPage() {
  const locale = useLocale();
  const router = useRouter();
  const [error, setError] = useState("");

  async function submit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();
    const form = new FormData(event.currentTarget);
    setError("");

    try {
      await login(String(form.get("username")), String(form.get("password")));
      router.push(`/${locale}/dashboard`);
    } catch {
      setError(locale === "ar" ? "تعذر تسجيل الدخول" : "Login failed");
    }
  }

  return (
    <main className="grid min-h-screen place-items-center p-4">
      <Card className="w-full max-w-md">
        <CardHeader>
          <CardTitle>{dictionaries[locale].appName}</CardTitle>
          <div className="text-sm text-muted-foreground">{t(locale, "login")}</div>
        </CardHeader>
        <CardContent>
          <form className="space-y-4" onSubmit={submit}>
            <label className="block space-y-2 text-sm font-semibold">
              <span>{t(locale, "username")}</span>
              <Input name="username" autoComplete="username" required />
            </label>
            <label className="block space-y-2 text-sm font-semibold">
              <span>{t(locale, "password")}</span>
              <Input name="password" type="password" autoComplete="current-password" required />
            </label>
            {error ? <div className="rounded-md bg-destructive/10 p-3 text-sm text-destructive">{error}</div> : null}
            <Button className="w-full" type="submit">{t(locale, "login")}</Button>
          </form>
        </CardContent>
      </Card>
    </main>
  );
}
