export const API_URL = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:8000/api/v1";

export type ApiTokens = {
  token_type: "Bearer";
  access_token: string;
  refresh_token: string;
  expires_in: number;
};

export type ApiUser = {
  id: number;
  username: string;
  name_ar: string;
  name_en?: string;
  roles?: Array<{
    slug: string;
    permissions?: Array<{ slug: string }>;
  }>;
};

export async function apiFetch<T>(path: string, init: RequestInit = {}): Promise<T> {
  const token = typeof window !== "undefined" ? localStorage.getItem("access_token") : null;
  const response = await fetch(`${API_URL}${path}`, {
    ...init,
    headers: {
      "Content-Type": "application/json",
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
      ...init.headers
    }
  });

  if (!response.ok) {
    throw new Error(await response.text());
  }

  return response.json() as Promise<T>;
}

export async function login(username: string, password: string) {
  const response = await apiFetch<{ user: ApiUser; tokens: ApiTokens }>("/auth/login", {
    method: "POST",
    body: JSON.stringify({ username, password })
  });

  localStorage.setItem("access_token", response.tokens.access_token);
  localStorage.setItem("refresh_token", response.tokens.refresh_token);
  localStorage.setItem("user", JSON.stringify(response.user));

  return response;
}

export function currentUser(): ApiUser | null {
  if (typeof window === "undefined") return null;
  const raw = localStorage.getItem("user");
  return raw ? (JSON.parse(raw) as ApiUser) : null;
}

export function hasPermission(permission: string) {
  const user = currentUser();
  if (!user) return false;
  if (user.roles?.some((role) => role.slug === "super-admin")) return true;

  return Boolean(user.roles?.some((role) => role.permissions?.some((item) => item.slug === permission)));
}
