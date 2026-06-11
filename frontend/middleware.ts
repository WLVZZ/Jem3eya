import { NextResponse, type NextRequest } from "next/server";

const locales = ["ar", "en"];

export function middleware(request: NextRequest) {
  const { pathname } = request.nextUrl;
  const hasLocale = locales.some((locale) => pathname === `/${locale}` || pathname.startsWith(`/${locale}/`));

  if (!hasLocale && !pathname.startsWith("/api") && !pathname.startsWith("/_next")) {
    request.nextUrl.pathname = `/ar${pathname}`;
    return NextResponse.redirect(request.nextUrl);
  }

  return NextResponse.next();
}

export const config = {
  matcher: ["/((?!_next/static|_next/image|favicon.ico|manifest.webmanifest|sw.js|icon.svg).*)"]
};
