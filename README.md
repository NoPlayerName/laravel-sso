# Laravel SSO

Project Laravel ini berfungsi sebagai auth server dengan Laravel Passport (OAuth2) + login lokal.

## Fitur

- Register akun lokal
- Login / logout
- Reset password lokal via email log
- Dashboard yang dilindungi session auth
- Docker untuk app, Nginx, dan PostgreSQL
- OAuth2 authorization server via Passport (`/oauth/*`)
- API token (Bearer) untuk integrasi banyak aplikasi di `/api/v1/auth/*`

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

4. Inisialisasi Passport (keys + tabel + client):

```bash
docker compose exec app php artisan passport:install
```

5. Buka aplikasi:

- http://localhost:8080/register untuk membuat akun
- http://localhost:8080/login untuk masuk
- http://localhost:8080/forgot-password untuk minta reset password
- http://localhost:8080/dashboard untuk halaman utama setelah login

## OAuth2 SSO (untuk aplikasi lain)

Endpoint standar OAuth2 dari Passport tersedia di:

- `POST /oauth/token`
- `GET|POST|DELETE /oauth/authorize`

Contoh membuat client OAuth untuk aplikasi lain:

```bash
docker compose exec app php artisan passport:client --name="My Web Client" --provider=users --redirect_uri="http://localhost:8081/auth/callback"
docker compose exec app php artisan passport:client --public --name="My PKCE Client" --provider=users --redirect_uri="http://localhost:8081/auth/callback"
```

Alternatif tanpa CLI:

1. Login ke aplikasi (`/login`).
2. Buka halaman `http://localhost:8080/oauth/clients`.
3. Isi form `Nama Aplikasi`, `Jenis Client`, dan `Redirect URI`.
4. Klik `Buat OAuth Client`.
5. Simpan `Client ID` (dan `Client Secret` jika tipe Confidential) dari notifikasi hasil.

## API Auth Token (untuk aplikasi lain)

Semua endpoint API ada di prefix `/api/v1`.

1. Register + dapat token

```bash
curl -X POST http://localhost:8080/api/v1/auth/register \
	-H "Content-Type: application/json" \
	-H "Accept: application/json" \
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
	-H "Accept: application/json" \
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

- Dari container (`app` ke `db`): `db:5432`
- Dari host machine (DBeaver): `127.0.0.1:5433`
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

- API guard memakai Passport (`auth:api`).
- Email reset password dikirim ke `MAIL_MAILER=log`, jadi link-nya bisa dilihat di log aplikasi.
- Untuk integrasi OIDC (ID Token + discovery/JWKS), diperlukan layer tambahan di atas OAuth2 Passport.
