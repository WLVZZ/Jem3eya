import type { Locale } from "@/lib/i18n";
import { AuthGuard } from "@/components/layout/auth-guard";
import { Sidebar } from "@/components/layout/sidebar";
import { Topbar } from "@/components/layout/topbar";

export function ErpShell({ children }: { locale: Locale; children: React.ReactNode }) {
  return (
    <AuthGuard>
      <div className="flex min-h-screen">
        <Sidebar />
        <div className="min-w-0 flex-1">
          <Topbar />
          <main className="mx-auto w-full max-w-7xl p-4 lg:p-6">{children}</main>
        </div>
      </div>
    </AuthGuard>
  );
}
