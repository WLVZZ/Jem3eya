"use client";

import { usePathname } from "next/navigation";
import type { Locale } from "@/lib/i18n";

export function useLocale(): Locale {
  const pathname = usePathname();
  const locale = pathname.split("/")[1];

  return locale === "en" ? "en" : "ar";
}
