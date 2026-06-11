"use client";

import Link from "next/link";
import { usePathname, useRouter } from "next/navigation";
import { LogOut, Moon, Sun } from "lucide-react";
import { useTheme } from "next-themes";
import { Button } from "@/components/ui/button";
import { dictionaries, t } from "@/lib/i18n";
import { useLocale } from "@/lib/use-locale";

export function Topbar() {
  const locale = useLocale();
  const pathname = usePathname();
  const router = useRouter();
  const { theme, setTheme } = useTheme();
  const otherLocale = locale === "ar" ? "en" : "ar";

  function logout() {
    localStorage.removeItem("access_token");
    localStorage.removeItem("refresh_token");
    localStorage.removeItem("user");
    router.replace(`/${locale}/login`);
  }

  return (
    <header className="flex h-16 items-center justify-between border-b bg-card px-4 lg:px-6">
      <div>
        <div className="text-sm font-bold">{dictionaries[locale].appName}</div>
        <div className="text-xs text-muted-foreground">Enterprise Resource Planning</div>
      </div>
      <div className="flex items-center gap-2">
        <Link
          className="rounded-md border px-3 py-2 text-xs font-bold hover:bg-muted"
          href={pathname.replace(`/${locale}`, `/${otherLocale}`)}
        >
          {otherLocale.toUpperCase()}
        </Link>
        <Button
          size="icon"
          variant="secondary"
          aria-label="Theme"
          onClick={() => setTheme(theme === "dark" ? "light" : "dark")}
        >
          <Sun className="h-4 w-4 dark:hidden" />
          <Moon className="hidden h-4 w-4 dark:block" />
        </Button>
        <Button variant="secondary" onClick={logout}>
          <LogOut className="h-4 w-4" />
          {t(locale, "logout")}
        </Button>
      </div>
    </header>
  );
}
