import http from "node:http";

const permissions = [
  "dashboard.kpis.view",
  "hr.employees.view",
  "hr.employees.manage",
  "payroll.runs.view",
  "payroll.runs.create",
  "payroll.runs.calculate",
  "payroll.runs.approve",
  "payroll.runs.close",
  "finance.accounts.view",
  "finance.accounts.manage",
  "finance.journals.view",
  "inventory.items.view",
  "inventory.items.create",
  "projects.projects.view",
  "projects.projects.manage",
  "documents.documents.view",
  "documents.documents.upload"
];

const user = {
  id: 1,
  username: "admin",
  name_ar: "مدير النظام",
  name_en: "System Administrator",
  roles: [
    {
      slug: "super-admin",
      permissions: permissions.map((slug) => ({ slug }))
    }
  ]
};

function json(res, status, body) {
  res.writeHead(status, {
    "Content-Type": "application/json",
    "Access-Control-Allow-Origin": "*",
    "Access-Control-Allow-Headers": "Content-Type, Authorization",
    "Access-Control-Allow-Methods": "GET,POST,PUT,DELETE,OPTIONS"
  });
  res.end(JSON.stringify(body));
}

function readBody(req) {
  return new Promise((resolve) => {
    let raw = "";
    req.on("data", (chunk) => {
      raw += chunk;
    });
    req.on("end", () => resolve(raw ? JSON.parse(raw) : {}));
  });
}

const server = http.createServer(async (req, res) => {
  if (req.method === "OPTIONS") return json(res, 204, {});

  if (req.url === "/api/v1/auth/login" && req.method === "POST") {
    const body = await readBody(req);

    if (body.username === "admin" && body.password === "ChangeMe!234") {
      return json(res, 200, {
        user,
        tokens: {
          token_type: "Bearer",
          access_token: "local-preview-token",
          refresh_token: "local-preview-refresh",
          expires_in: 3600
        }
      });
    }

    return json(res, 422, { message: "Invalid credentials." });
  }

  if (req.url === "/api/v1/auth/me") return json(res, 200, { user });

  if (req.url === "/api/v1/dashboard/kpis") {
    return json(res, 200, {
      employee_count: 248,
      monthly_payroll_total: 378000,
      revenues: 920000,
      expenses: 470000,
      active_projects: 41
    });
  }

  return json(res, 404, { message: "Local preview endpoint not implemented." });
});

server.listen(8000, "0.0.0.0", () => {
  console.log("Local preview API listening on http://localhost:8000");
});
