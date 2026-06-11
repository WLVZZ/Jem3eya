"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { useLocale } from "@/lib/use-locale";

export function AuthGuard({ children }: { children: React.ReactNode }) {
  const router = useRouter();
  const locale = useLocale();
  const [ready, setReady] = useState(false);

  useEffect(() => {
    if (!localStorage.getItem("access_token")) {
      router.replace(`/${locale}/login`);
      return;
    }
    setReady(true);
  }, [locale, router]);

  if (!ready) {
    return <div className="grid min-h-screen place-items-center text-sm text-muted-foreground">Loading...</div>;
  }

  return children;
}
