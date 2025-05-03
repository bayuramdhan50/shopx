# Arsitektur Teknis ShopX

Dokumen ini menjelaskan arsitektur teknis aplikasi ShopX, berfokus pada implementasi sistem, alur kerja, dan komponen teknologi yang digunakan.

## Overview Arsitektur

ShopX menggunakan arsitektur MVC (Model-View-Controller) dengan Laravel sebagai framework utama. Diagram arsitektur tingkat tinggi adalah sebagai berikut:

```
┌────────────────┐      ┌───────────────┐      ┌───────────────┐
│    Browser     │─────►│  Controllers  │─────►│    Models     │
│  (Frontend)    │◄─────│   (Logic)     │◄─────│   (Data)      │
└────────────────┘      └───────────────┘      └───────┬───────┘
                                                       │
                                                       ▼
                                               ┌───────────────┐
                                               │   Database    │
                                               │   (MySQL)     │
                                               └───────────────┘
```

## Komponen Utama

### 1. Frontend

- **Views**: Blade templates dengan Tailwind CSS
- **JavaScript**: Alpine.js untuk interaktivitas UI
- **Assets**: Dikelola melalui Vite

### 2. Backend

- **Controllers**: Menangani request dan business logic
- **Models**: Berintegrasi dengan database dan mengelola data
- **Services**: Logika bisnis yang kompleks dienkapsulasi dalam service classes

### 3. Database

- **ORM**: Eloquent ORM
- **Migrations**: Versi database terstruktur
- **Seeds**: Data awal untuk testing

## Alur Kerja Aplikasi

### 1. Alur Pembelian

```
┌─────────┐     ┌──────────┐     ┌─────────────┐     ┌──────────────┐     ┌───────────┐
│ Katalog │────►│ Keranjang│────►│   Checkout  │────►│  Pembayaran  │────►│ Konfirmasi│
└─────────┘     └──────────┘     └─────────────┘     └──────────────┘     └───────────┘
```

### 2. Alur Enkripsi Data

```
┌──────────────┐     ┌───────────────┐     ┌─────────────────┐
│ Input Data   │────►│  Encryptable  │────►│  AES-256        │
│ Sensitif     │     │  Trait        │     │  Encryption     │
└──────────────┘     └───────────────┘     └─────────────────┘
       │
       │                                     Untuk data sangat sensitif
       ▼
┌──────────────┐     ┌───────────────┐     ┌─────────────────┐
│ Opsi Enkripsi│────►│  Enhanced     │────►│  PBKDF2 + AES   │
│ Lanjutan     │     │  Encryptable  │     │  Encryption     │
└──────────────┘     └───────────────┘     └─────────────────┘
```

## Implementasi Model

### Model Utama dan Relasi

- **User**: Pengguna aplikasi
- **Product**: Produk yang dijual
- **Category**: Kategori produk
- **CartItem**: Item dalam keranjang
- **Order**: Pesanan
- **OrderItem**: Item dalam pesanan
- **PaymentMethod**: Metode pembayaran yang disimpan

Diagram relasi:

```
                    ┌───────────┐
                    │ Category  │
                    └─────┬─────┘
                          │
┌───────────┐      ┌─────▼─────┐      ┌───────────┐
│ CartItem  │◄────►│  Product  │◄─────┤OrderItem  │
└─────┬─────┘      └───────────┘      └─────┬─────┘
      │                                     │
      │            ┌───────────┐            │
      └───────────►│   User    │◄───────────┘
                   └─────┬─────┘
                         │
                         ▼
                   ┌───────────┐
                   │  Order    │
                   └───────────┘
                         ▲
                         │
                   ┌───────────┐
                   │ Payment   │
                   │ Method    │
                   └───────────┘
```

## Implementasi Keamanan

### 1. Trait Encryptable

```php
trait Encryptable
{
    public static function bootEncryptable(): void
    {
        static::saving(function ($model) {
            $model->encryptAttributes();
        });

        static::retrieved(function ($model) {
            $model->decryptAttributes();
        });
    }
    
    // Metode untuk enkripsi/dekripsi atribut
}
```

### 2. Trait EnhancedEncryptable

```php
trait EnhancedEncryptable
{
    public static function bootEnhancedEncryptable(): void
    {
        static::saving(function ($model) {
            $model->encryptEnhancedAttributes();
        });

        static::retrieved(function ($model) {
            $model->decryptEnhancedAttributes();
        });
    }
    
    // Metode untuk enkripsi/dekripsi atribut dengan PBKDF2
}
```

### 3. PBKDF2 Service

```php
class PBKDF2Service
{
    protected int $iterations = 10000;
    
    // Metode untuk derivasi kunci
    public function strengthenKey(string $masterKey, string $salt): array
    {
        $derivedKey = hash_pbkdf2(
            $this->hashAlgorithm,
            $masterKey,
            $salt,
            $this->iterations,
            $this->keyLength,
            true
        );
        
        // Hasil derivasi
    }
    
    // Metode enkripsi/dekripsi
}
```

## Implementasi Admin

ShopX menggunakan Filament Admin Panel untuk backend:

- **Dashboard**: Statistik dan metrik
- **Resource Management**: CRUD untuk entitas aplikasi
- **Security Dashboard**: Metrik dan visualisasi keamanan
- **Pengguna**: Manajemen akun dan izin

## Optimasi dan Performa

- **Query Caching**: Cache untuk query yang sering digunakan
- **View Caching**: Compiler cache untuk view
- **Eager Loading**: Optimasi lazy loading untuk relasi model
- **Asset Bundling**: Kompilasi dan minifikasi CSS/JS

## Pengujian

- **PHPUnit**: Unit dan feature testing
- **Browser Testing**: Pengujian UI dan alur pengguna
- **Security Testing**: Pengujian implementasi keamanan

## Deployment dan DevOps

- **Environment**: Development, Testing, Production
- **CI/CD**: Continuous Integration pipeline
- **Monitoring**: Logging dan monitoring error
- **Backup**: Strategi backup database dan file
