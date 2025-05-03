<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Keamanan-Multi--Layer-blue" alt="Multi-Layer Security">
<img src="https://img.shields.io/badge/Enkripsi-AES--256%20%2B%20PBKDF2-green" alt="AES-256 + PBKDF2">
<img src="https://img.shields.io/badge/Framework-Laravel%2012.12.0-red" alt="Laravel 10">
<img src="https://img.shields.io/badge/Admin-Filament-purple" alt="Filament Admin">
</p>

# ShopX - Aplikasi E-Commerce dengan Keamanan Multi-Layer

ShopX adalah aplikasi e-commerce dengan fokus pada keamanan data yang berlapis. Aplikasi ini dibangun sebagai studi kasus implementasi keamanan jaringan menggunakan Laravel dan teknik enkripsi modern untuk melindungi data sensitif pengguna.

## Tentang Proyek

Proyek ini dikembangkan untuk memenuhi kebutuhan studi kasus mata kuliah Keamanan Jaringan, dengan tujuan utama mendemonstrasikan implementasi enkripsi AES-256 yang diperkuat dengan PBKDF2 sebagai solusi perlindungan data sensitif dalam aplikasi web.

### Latar Belakang

Keamanan data dalam aplikasi e-commerce sangat krusial karena melibatkan informasi sensitif seperti:
- Detail kartu kredit/debit
- Informasi identitas pribadi
- Riwayat transaksi keuangan

ShopX mengimplementasikan pendekatan enkripsi berlapis untuk memastikan keamanan data yang optimal.

## Arsitektur Aplikasi

ShopX dibangun dengan arsitektur MVC (Model-View-Controller) menggunakan framework Laravel dengan komponen utama:

### Frontend
- Blade templating + Tailwind CSS
- JavaScript untuk interaksi pengguna
- Responsive design

### Backend
- Laravel 12 Framework
- MySQL Database
- RESTful API endpoints

### Admin Panel
- Filament admin dashboard
- Visualisasi keamanan data
- Pengelolaan produk & pengguna

## Fitur Utama

### 1. Katalog Produk
- Pencarian dan filtrasi produk
- Kategorisasi produk
- Detail produk dengan gambar dan deskripsi
- Stok realtime

### 2. Keranjang & Checkout
- Manajemen keranjang belanja
- Kalkulasi harga otomatis
- Alamat pengiriman yang terenkripsi
- Validasi checkout multi-langkah

### 3. Sistem Pembayaran Aman
- Dukungan untuk kartu kredit/debit
- Opsi transfer bank
- Enkripsi detail pembayaran
- Enkripsi lanjutan (PBKDF2) untuk data sensitif

### 4. Manajemen Akun
- Profil pengguna terenkripsi
- Riwayat pembelian
- Manajemen metode pembayaran
- Pengaturan keamanan pengguna

### 5. Panel Admin
- Dashboard analitik
- Manajemen produk dan kategori
- Monitor keamanan
- Dashboard audit enkripsi
- Visualisasi data keamanan

## Arsitektur Keamanan

ShopX mengimplementasikan arsitektur keamanan berlapis sebagai berikut:

### 1. Enkripsi Data Standar (AES-256)
- **Implementasi**: Menggunakan Laravel Encrypter dengan AES-256-CBC
- **Data**: Detail pembayaran, alamat, data transaksi
- **Metode**: `App\Traits\Encryptable` trait

### 2. Enkripsi Tingkat Lanjut (PBKDF2 + AES-256)
- **Implementasi**: Custom PBKDF2Service
- **Konfigurasi**: 10,000 iterasi dengan salt unik
- **Data**: CVV kartu kredit dan data sangat sensitif
- **Metode**: `App\Services\Security\PBKDF2Service`

### 3. Opsi Keamanan Pengguna
- Pilihan untuk mengaktifkan enkripsi lanjutan
- Indikator visual tingkat keamanan
- Audit log untuk operasi sensitif

### 4. Protokol Keamanan Web
- CSRF protection pada semua form
- XSS prevention
- Validasi input & sanitasi output
- Rate limiting untuk mencegah brute force
- Session security

## Dokumentasi Keamanan

Proyek ini dilengkapi dengan dokumentasi keamanan yang komprehensif:

### [SECURITY-DOCS.md](SECURITY-DOCS.md)
Dokumentasi teknis tentang implementasi keamanan ShopX yang mencakup:
- Alasan pemilihan AES-256 vs algoritma lain
- Risiko dan mitigasi kebocoran kunci
- Pengelolaan kunci (key management)
- Langkah-langkah enkripsi dan dekripsi
- Perbandingan enkripsi simetris vs asimetris
- Framework audit keamanan

### [IMPLEMENTATION-STEPS.md](IMPLEMENTATION-STEPS.md)
Langkah-langkah detail implementasi PBKDF2 di ShopX:
- Perubahan database
- Pembuatan service dan trait
- Implementasi controllers
- Form interface
- Dashboard admin keamanan

## Instalasi dan Penggunaan

### Persyaratan Sistem
- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL 5.7+ / MariaDB 10.3+

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/bayuramdhan50/shopx.git
cd shopx

# 2. Instal dependensi
composer install
npm install

# 3. Persiapkan environment
copy .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=shopx
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migrasi dan seeder
php artisan migrate --seed

# 6. Compile assets
npm run build

# 7. Jalankan server
php artisan serve
```

### Login Admin
- Email: admin@shopx.com
- Password: password123

## Struktur Proyek

```
shopx/
├── app/                             # Backend Application Code
│   ├── Http/Controllers/            # Request handlers
│   ├── Models/                      # Database models
│   ├── Services/Security/           # Security services
│   │   ├── PBKDF2Service.php        # PBKDF2 implementation
│   │   └── EncryptionService.php    # Encryption utilities
│   └── Traits/                      # Reusable traits
│       ├── Encryptable.php          # AES-256 encryption
│       └── EnhancedEncryptable.php  # PBKDF2 enhanced encryption
├── database/
│   └── migrations/                  # Database structure
├── resources/
│   └── views/                       # Frontend templates
│       ├── payment_methods/         # Payment method forms
│       └── filament/pages/          # Admin dashboard
└── config/
    └── security.php                 # Security configuration
```

## Fitur Keamanan Lanjutan

### 1. Visualisasi Keamanan
Dashboard admin khusus untuk memonitor dan memvisualisasikan status keamanan data:
- Statistik data terenkripsi
- Metrik penggunaan PBKDF2
- Audit log untuk aktivitas keamanan

### 2. Opsi Keamanan End-User
- Toggle untuk mengaktifkan enkripsi PBKDF2 pada CVV
- Informasi edukasi tentang keamanan data
- Indikator kekuatan enkripsi per data

### 3. Salt Unik per Data
- Setiap data memiliki salt unik
- Context binding untuk mencegah replay attack
- Salt dikaitkan dengan user_id untuk keamanan tambahan

## Framework dan Library

Aplikasi ini dibangun menggunakan kombinasi:
- **Laravel 12**: Framework PHP untuk backend
- **Filament Admin**: Panel admin yang elegan
- **Tailwind CSS**: Framework CSS untuk UI responsif
- **Alpine.js**: JavaScript untuk interaksi UI ringan

## Tim Pengembang

- **Pengembang Utama**: Bayu Ramdhan Ardiyanto | Davney Restra Danaz
- **Mata Kuliah**: Keamanan Jaringan
- **Semester**: 6
- **Tahun**: 2025

## License

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
