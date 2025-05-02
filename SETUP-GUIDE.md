# Panduan Setup Aplikasi ShopX

Panduan ini menjelaskan langkah-langkah untuk melakukan setup aplikasi ShopX pada sistem baru (clone repository).

## Prasyarat

1. PHP 8.1 atau lebih baru
2. Composer
3. MySQL atau SQLite
4. Node.js dan npm (untuk aset frontend)

## Langkah Setup

### 1. Clone Repository

```bash
git clone <url-repository-shopx>
cd shopx
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Setup Lingkungan

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database

#### Opsi A: MySQL

1. Buat database baru di MySQL
2. Edit file `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=shopx
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

#### Opsi B: SQLite (Alternatif)

1. Buat file database SQLite:
   ```bash
   touch database/database.sqlite
   ```
2. Edit file `.env`:
   ```
   DB_CONNECTION=sqlite
   # Komentar/hapus konfigurasi MySQL lainnya
   ```

### 5. Migrasi dan Seeding Database

```bash
php artisan migrate --seed
```

### 6. Menyiapkan Storage

```bash
php artisan storage:link
```

### 7. Bersihkan Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 8. Kompilasi Aset Frontend

```bash
npm run dev
```

### 9. Jalankan Server

```bash
php artisan serve
```

## Pemecahan Masalah Umum

### Error "could not find driver"

Ini berarti ekstensi database (mysql/sqlite) belum diaktifkan di PHP. Pastikan ekstensi tersebut aktif:

```bash
php -m | grep mysql   # untuk MySQL
php -m | grep sqlite  # untuk SQLite
```

Jika tidak ada, aktifkan di file `php.ini` (hapus `;` di depan):
```
extension=pdo_mysql
extension=mysqli
extension=pdo_sqlite
```

### Error "No application encryption key has been specified"

Jalankan:
```bash
php artisan key:generate
```

### Error Koneksi Database

1. Pastikan server database berjalan
2. Pastikan nama pengguna dan kata sandi benar
3. Pastikan database sudah dibuat

## Untuk Pengembangan

- **Filament Admin Panel**: Akses di `/admin` dengan akun admin dari database
- **API Testing**: Gunakan Postman atau Insomnia dengan endpoint di `routes/api.php`

## Informasi Tambahan

- Sistem enkripsi menggunakan AES-256 untuk data sensitif.
- Session disimpan di database.
