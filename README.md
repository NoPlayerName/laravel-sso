# Laravel SSO

Project Laravel ini memakai login lokal saja dengan Docker Compose. Tidak ada provider SSO eksternal.

## Fitur

- Register akun lokal
- Login / logout
- Reset password lokal via email log
- Dashboard yang dilindungi session auth
- Docker untuk app, Nginx, dan PostgreSQL
- API token (Bearer) untuk integrasi banyak aplikasi

## Jalankan dengan Docker

1. Build dan start container:

```bash
docker compose up -d --build
```

2. Jika ini pertama kali dijalankan, app container akan menyalin `.env.example` menjadi `.env`, membuat `APP_KEY`, dan menyiapkan vendor dependency.

3. Jalankan migrasi database:

```bash
docker compose exec app php artisan migrate
```

4. Buka aplikasi:

- http://localhost:8080/register untuk membuat akun
- http://localhost:8080/login untuk masuk
- http://localhost:8080/forgot-password untuk minta reset password
- http://localhost:8080/dashboard untuk halaman utama setelah login

## API Auth Token (untuk aplikasi lain)

Semua endpoint API ada di prefix `/api/v1`.

1. Register + dapat token

```bash
curl -X POST http://localhost:8080/api/v1/auth/register \
	-H "Content-Type: application/json" \
	-d '{
		"name":"Client User",
		"email":"client@example.com",
		"password":"password123",
		"password_confirmation":"password123",
		"client_name":"app-frontend"
	}'
```

2. Login + dapat token

```bash
curl -X POST http://localhost:8080/api/v1/auth/login \
	-H "Content-Type: application/json" \
	-d '{
		"email":"client@example.com",
		"password":"password123",
		"client_name":"app-mobile"
	}'
```

3. Ambil profil user (butuh bearer token)

```bash
curl http://localhost:8080/api/v1/auth/me \
	-H "Authorization: Bearer <ACCESS_TOKEN>"
```

4. Logout API (revoke token saat ini)

```bash
curl -X POST http://localhost:8080/api/v1/auth/logout \
	-H "Authorization: Bearer <ACCESS_TOKEN>"
```

## Detail akses database

- Host: db
- Port: 5432
- Database: laravel_sso
- User: laravel
- Password: secret

## Konfigurasi PostgreSQL Laravel

- DB_CONNECTION: pgsql
- DB_HOST: db
- DB_PORT: 5432
- DB_DATABASE: laravel_sso
- DB_USERNAME: laravel
- DB_PASSWORD: secret
- DB_SCHEMA: public
- DB_SSLMODE: prefer

Catatan: container `app` sudah meng-install ekstensi PHP `pdo_pgsql` (dan `pdo_mysql`) di [Dockerfile](Dockerfile).

## Catatan

- Project ini sengaja dibuat local auth only.
- Email reset password dikirim ke `MAIL_MAILER=log`, jadi link-nya bisa dilihat di log aplikasi.
- Jika Anda ingin nanti ditambah provider SSO tertentu, struktur ini sudah siap dikembangkan ke OAuth2/OIDC.
