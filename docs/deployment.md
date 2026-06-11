# Deployment Notes

## Production Checklist

- Replace default admin credentials.
- Set strong `APP_KEY` and `JWT_SECRET`.
- Use managed PostgreSQL backups.
- Enable Redis persistence or managed Redis.
- Put MinIO/S3 behind private network access.
- Configure HTTPS and secure cookies where applicable.
- Run queue workers separately.
- Add OpenAPI docs behind authenticated access.
- Add CAPTCHA provider.
- Add email/SMS/WhatsApp providers.

## Commands

```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan queue:work
npm run build
```
