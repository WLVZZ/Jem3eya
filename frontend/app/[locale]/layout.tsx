import { isRtl, type Locale } from "@/lib/i18n";

export default async function LocaleLayout({
  children,
  params
}: {
  children: React.ReactNode;
  params: Promise<{ locale: string }>;
}) {
  const { locale: rawLocale } = await params;
  const locale: Locale = rawLocale === "en" ? "en" : "ar";

  return (
    <div lang={locale} dir={isRtl(locale) ? "rtl" : "ltr"}>
      {children}
    </div>
  );
}
