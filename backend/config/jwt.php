<?php

return [
    'issuer' => env('JWT_ISSUER', env('APP_URL', 'jem3eya-erp')),
    'secret' => env('JWT_SECRET') ?: env('APP_KEY'),
    'access_ttl_minutes' => (int) env('JWT_ACCESS_TTL_MINUTES', 15),
    'refresh_ttl_days' => (int) env('JWT_REFRESH_TTL_DAYS', 14),
];
