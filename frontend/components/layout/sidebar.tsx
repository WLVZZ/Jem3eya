"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { cn } from "@/lib/utils";
import { dictionaries, t } from "@/lib/i18n";
import { useLocale } from "@/lib/use-locale";
import { hasPermission } from "@/lib/api";
import { navigation } from "@/lib/navigation";

export function Sidebar() {
  const locale = useLocale();
  const pathname = usePathname();

  return (
    <aside className="hidden w-72 shrink-0 border-e bg-card lg:block">
      <div className="flex h-16 items-center gap-3 border-b px-5">
        <div className="grid h-10 w-10 place-items-center rounded-md bg-primary text-sm font-black text-primary-foreground">
          ج
        </div>
        <div className="min-w-0">
          <div className="truncate text-sm font-bold">{dictionaries[locale].appName}</div>
          <div className="text-xs text-muted-foreground">ERP</div>
        </div>
      </div>
      <nav className="space-y-1 p-3">
        {navigation.filter((item) => hasPermission(item.permission)).map((item) => {
          const href = `/${locale}${item.href}`;
          const active = pathname === href;
          const Icon = item.icon;

          return (
            <Link
              key={item.href}
              href={href}
              className={cn(
                "flex h-10 items-center gap-3 rounded-md px-3 text-sm font-semibold transition",
                active ? "bg-primary text-primary-foreground" : "text-muted-foreground hover:bg-muted hover:text-foreground"
              )}
            >
              <Icon className="h-4 w-4" />
              {t(locale, item.labelKey as keyof typeof dictionaries.ar)}
            </Link>
          );
        })}
      </nav>
    </aside>
  );
}
