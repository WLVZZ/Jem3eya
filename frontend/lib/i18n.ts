export type Locale = "ar" | "en";

export function isRtl(locale: Locale) {
  return locale === "ar";
}

export const dictionaries = {
  ar: {
    appName: "جمعية الدعوة الإسلامية العالمية",
    login: "تسجيل الدخول",
    logout: "خروج",
    username: "اسم المستخدم",
    password: "كلمة المرور",
    dashboard: "لوحة التحكم",
    employees: "الموظفون",
    payroll: "المرتبات",
    finance: "المالية",
    accounts: "الحسابات",
    inventory: "المخازن",
    projects: "المشاريع",
    documents: "الأرشفة",
    reports: "التقارير",
    settings: "الإعدادات",
    search: "بحث",
    newRecord: "إضافة",
    save: "حفظ",
    status: "الحالة",
    amount: "المبلغ",
    period: "الفترة",
    reviewRequired: "يتطلب مراجعة قانونية"
  },
  en: {
    appName: "World Islamic Call Society",
    login: "Login",
    logout: "Logout",
    username: "Username",
    password: "Password",
    dashboard: "Dashboard",
    employees: "Employees",
    payroll: "Payroll",
    finance: "Finance",
    accounts: "Accounts",
    inventory: "Inventory",
    projects: "Projects",
    documents: "Documents",
    reports: "Reports",
    settings: "Settings",
    search: "Search",
    newRecord: "New",
    save: "Save",
    status: "Status",
    amount: "Amount",
    period: "Period",
    reviewRequired: "Legal review required"
  }
} satisfies Record<Locale, Record<string, string>>;

export function t(locale: Locale, key: keyof typeof dictionaries.ar) {
  return dictionaries[locale][key] ?? dictionaries.ar[key];
}
