import type { Locale } from "@/lib/i18n";
import { ErpShell } from "@/components/layout/erp-shell";

export default async function ErpLayout({
  children,
  params
}: {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
}) {
  const { locale: rawLocale } = await params;
  const locale: Locale = rawLocale === "en" ? "en" : "ar";
  return <ErpShell locale={locale}>{children}</ErpShell>;
}
