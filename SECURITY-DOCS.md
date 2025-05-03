# Dokumentasi Keamanan ShopX

## Arsitektur Enkripsi Data

Sistem ShopX menerapkan enkripsi data sensitif pengguna menggunakan metode enkripsi yang kuat dengan pendekatan multi-layer:

### 1. Enkripsi Data Standar (AES-256)

Data sensitif seperti detail pembayaran dan alamat pengguna dienkripsi menggunakan algoritma AES-256 melalui implementasi berikut:

- **Trait Encryptable**: Implementasi Laravel untuk mengenkripsi data model secara otomatis
- **Field Terenkripsi**: Kolom `encrypted_details` pada PaymentMethod
- **Kunci Enkripsi**: Menggunakan `APP_KEY` dari konfigurasi Laravel

### 2. Enkripsi yang Diperkuat (PBKDF2 + AES-256)

Untuk data yang sangat sensitif seperti nomor CVV kartu kredit, ShopX mengimplementasikan tambahan layer keamanan menggunakan PBKDF2:

- **PBKDF2Service**: Layanan dedicated untuk derivasi kunci menggunakan PBKDF2
- **Penggunaan Salt**: Salt unik untuk setiap data terenkripsi
- **Konteks Tambahan**: Pengikatan enkripsi ke konteks tertentu (user_id, entitas)
- **Iterasi Banyak**: 10.000 iterasi hash untuk memperkuat key derivation
- **Integrity Check**: Verifikasi integritas melalui konteks dan metadata

#### Diagram Proses PBKDF2 + AES-256

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Data Mentah │────►│  PBKDF2 Key │────►│  Enkripsi   │────►│ Data        │
│             │     │  Derivation │     │  AES-256    │     │ Terenkripsi │
└─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘
       ▲                   ▲                   ▲
       │                   │                   │
       │                   │                   │
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│ Konteks     │     │ Salt Unik   │     │ APP_KEY     │
│ User & Data │     │ per Data    │     │ (Master Key)│
└─────────────┘     └─────────────┘     └─────────────┘
```

#### Alur Kerja Enkripsi Diperkuat

1. **Input Data**: Data sensitif diterima dari pengguna (e.g., CVV)
2. **Persiapan Konteks**: Konteks khusus dibuat (user_id, jenis data)
3. **Pembuatan Salt**: Salt unik dibuat untuk data ini
4. **Key Derivation**:
   - APP_KEY digunakan sebagai password dasar
   - PBKDF2 menjalankan 10.000 iterasi dengan salt untuk menghasilkan kunci turunan
5. **Enkripsi AES-256**: Data dienkripsi menggunakan kunci turunan
6. **Penyimpanan**: Data terenkripsi + salt + metadata disimpan

## FAQ Keamanan 

### 1. Mengapa AES-256 dipilih dibandingkan algoritma enkripsi lain yang lebih sederhana (seperti AES-128)?

AES-256 menyediakan margin keamanan yang lebih besar dibanding AES-128 dengan beberapa keunggulan:

- **Resistensi Quantum**: AES-256 lebih tahan terhadap serangan komputer kuantum
- **Standar Regulasi**: Memenuhi standar keamanan tinggi seperti FIPS 140-2
- **Ukuran Kunci**: 256-bit key space menawarkan resistensi yang jauh lebih baik terhadap brute force
- **Future-proofing**: Daya tahan keamanan untuk jangka waktu lebih panjang

### 2. Apa risiko jika kunci enkripsi AES-256 bocor, dan bagaimana mitigasinya?

**Risiko:**
- Pengungkapan semua data terenkripsi
- Manipulasi data sensitif
- Kemungkinan identifikasi pribadi (PII) terungkap

**Mitigasi:**
- **PBKDF2 Key Derivation**: Derivasi kunci multi-iterasi
- **Salt Unik**: Penggunaan salt khusus per data
- **Key Rotation**: Proses rotasi kunci secara berkala
- **Konteks Enkripsi**: Pengikatan enkripsi ke konteks spesifik
- **Monitoring & Audit**: Deteksi dini kebocoran kunci

### 3. Bagaimana implementasi sistem pengelolaan kunci (key management) yang baik untuk kasus ini?

ShopX menerapkan pendekatan berlapis untuk pengelolaan kunci:

- **Penyimpanan Aman**: APP_KEY disimpan dalam file .env yang tidak dicommit ke repository
- **Pembatasan Akses**: Pembatasan akses ke file konfigurasi yang berisi kunci
- **Derivasi Kunci**: Penggunaan PBKDF2 untuk menghasilkan kunci turunan berbeda untuk setiap data
- **Salt Management**: Penyimpanan salt bersamaan dengan data terenkripsi 
- **Context Binding**: Pengikatan kunci ke konteks untuk mencegah misuse

### 4. Langkah-langkah umum untuk mengenkripsi dan mendekripsi data pengguna menggunakan AES-256 di server backend

**Proses Enkripsi:**
1. Validasi dan sanitasi data input
2. Generate salt unik
3. Derive kunci menggunakan PBKDF2 dari APP_KEY dan salt
4. Enkripsi data dengan AES-256 menggunakan kunci yang diturunkan
5. Simpan salt bersama dengan data terenkripsi
6. Tambahkan metadata (method, iterasi, versi)

**Proses Dekripsi:**
1. Ekstrak salt dan metadata dari data terenkripsi
2. Derive kunci yang sama menggunakan PBKDF2
3. Dekripsi data menggunakan AES-256
4. Validasi hasil dekripsi

### 5. Kekurangan enkripsi simetris (seperti AES) untuk proteksi data pengguna, dibandingkan dengan enkripsi asimetris (seperti RSA)

**Kekurangan AES (Simetris):**
- Memerlukan penyimpanan kunci rahasia tunggal
- Kesulitan berbagi kunci secara aman
- Tantangan pengelolaan kunci untuk banyak pengguna

**Kelebihan RSA (Asimetris):**
- Tidak perlu berbagi kunci rahasia
- Manajemen kunci yang lebih sederhana
- Lebih cocok untuk komunikasi antar pihak

**Solusi ShopX:**
- Menggunakan enkripsi simetris untuk efisiensi penyimpanan data
- Meningkatkan keamanan melalui PBKDF2 key derivation
- Enkripsi data per-pengguna dengan kunci unik

### 6. Bagaimana sebaiknya proses audit keamanan dilakukan untuk memastikan enkripsi berjalan dengan benar di website ShopX?

**Framework Audit:**
- **Regular Review**: Pemeriksaan berkala implementasi enkripsi
- **Penetration Testing**: Pengujian keamanan eksternal
- **Logging**: Pencatatan semua operasi enkripsi/dekripsi
- **Key Rotation**: Verifikasi proses rotasi kunci
- **Error Monitoring**: Pemantauan kegagalan enkripsi/dekripsi
- **Compliance Check**: Memastikan kepatuhan terhadap standar dan regulasi

## Referensi Teknis PBKDF2

PBKDF2 (Password-Based Key Derivation Function 2) adalah fungsi derivasi kunci yang dirancang untuk membuat kunci kriptografi dari string password melalui proses komputasi intensif. Berikut adalah detail implementasi di ShopX:

```php
// Contoh penggunaan PBKDF2 di ShopX
$pbkdf2Service = app(\App\Services\Security\PBKDF2Service::class);

// Enkripsi data sensitif dengan PBKDF2 + AES-256
$encrypted = $pbkdf2Service->encrypt($sensitiveData, "user_payment_" . $userId);

// Dekripsi data 
$decrypted = $pbkdf2Service->decrypt($encrypted, "user_payment_" . $userId);
```

Kelebihan PBKDF2 dibanding derivasi kunci sederhana:
- Ketahanan terhadap serangan brute force
- Ketahanan terhadap serangan dictionary
- Penggunaan salt untuk mencegah table lookup attacks
- Iterasi yang dapat dikonfigurasi untuk menyesuaikan keamanan vs performa
