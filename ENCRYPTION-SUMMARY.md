# Ringkasan Sistem Enkripsi dan Dekripsi ShopX

## Mekanisme Enkripsi Data Multi-Layer

Aplikasi ShopX mengimplementasikan sistem keamanan berlapis untuk melindungi data sensitif pengguna. Sistem ini terdiri dari:

### 1. Enkripsi Standar dengan AES-256

Enkripsi standar digunakan untuk mayoritas data sensitif seperti detail kartu kredit (kecuali CVV), data alamat, dan informasi transaksi. Sistem ini menggunakan algoritma AES-256 yang diimplementasikan melalui Laravel's encryption services.

**Proses Enkripsi:**
1. Data sensitif diterima dari input pengguna
2. Data dienkripsi menggunakan algoritma AES-256-CBC
3. Kunci enkripsi berasal dari APP_KEY aplikasi
4. Hasil enkripsi ditambahkan dengan MAC (Message Authentication Code)
5. Data terenkripsi disimpan dalam database

**Proses Dekripsi:**
1. Data terenkripsi diambil dari database
2. MAC diverifikasi untuk memastikan integritas data
3. Data didekripsi menggunakan APP_KEY
4. Data asli dikembalikan ke aplikasi

### 2. Enkripsi Lanjutan dengan PBKDF2 + AES-256

Untuk data yang sangat sensitif (seperti CVV kartu kredit), ShopX mengimplementasikan lapisan keamanan tambahan menggunakan PBKDF2 (Password-Based Key Derivation Function 2).

**Proses Enkripsi:**
1. Data sensitif diterima dari input pengguna
2. Salt unik dihasilkan untuk setiap data
3. Konteks tambahan (user_id) ditambahkan ke salt
4. PBKDF2 dijalankan dengan 10,000 iterasi untuk memperkuat kunci
5. Kunci turunan digunakan untuk mengenkripsi data dengan AES-256
6. Metadata (salt, iterasi, dll) disimpan bersama data terenkripsi
7. Hasil akhir disimpan dalam format terstruktur di database

**Proses Dekripsi:**
1. Data terenkripsi dan metadata diambil dari database
2. Salt dan IV (Initialization Vector) diekstrak dari metadata
3. Konteks divalidasi untuk memastikan otentisitas
4. PBKDF2 dijalankan dengan parameter yang sama untuk menghasilkan kunci yang sama
5. AES-256 digunakan untuk mendekripsi data dengan kunci turunan
6. Data asli dikembalikan ke aplikasi

## Keunggulan Sistem Ini

### Perlindungan Terhadap Serangan Umum

1. **Brute Force Attacks**: PBKDF2 dengan 10,000 iterasi membuat upaya brute force menjadi sangat mahal secara komputasional
2. **Rainbow Table Attacks**: Salt unik per data mencegah penggunaan rainbow tables
3. **Side-Channel Attacks**: Penggunaan MAC dan timing-safe comparison mengurangi risiko side-channel attacks
4. **Data Theft**: Bahkan jika database dicuri, data tetap terenkripsi dan sulit didekripsi tanpa kunci

### Pengikatan Konteks untuk Keamanan Tambahan

Sistem keamanan ShopX mengimplementasikan pengikatan konteks, di mana data terenkripsi terikat dengan konteks spesifik seperti user_id. Ini mencegah serangan replay di mana penyerang mencoba menggunakan data terenkripsi milik satu pengguna untuk pengguna lain.

### Arsitektur Modular dan Terstruktur

Implementasi enkripsi ShopX menggunakan pendekatan berorientasi objek yang modular:

1. **Encryptable Trait**: Menangani enkripsi/dekripsi standar (AES-256)
2. **EnhancedEncryptable Trait**: Menangani enkripsi/dekripsi lanjutan (PBKDF2 + AES-256)
3. **PBKDF2Service**: Service khusus untuk operasi PBKDF2 dan manajemen salt

## Diagram Alur Proses Enkripsi-Dekripsi

```
┌──────────────┐                                   ┌───────────────┐
│  Input Data  │                                   │ Output Data   │
│  Sensitif    │                                   │ Terdekripsi   │
└──────┬───────┘                                   └───────┬───────┘
       │                                                   ▲
       │                                                   │
       ▼                                                   │
┌──────────────┐    ┌─────────────┐    ┌─────────────┐    │
│ Pilih Jenis  ├───►│ AES-256     ├───►│ Dekripsi    │    │
│ Enkripsi     │    │ Standar     │    │ AES-256     ├────┘
└──────┬───────┘    └─────────────┘    └─────────────┘
       │
       │            ┌─────────────┐    ┌─────────────┐    ┌─────────────┐
       └───────────►│ PBKDF2 +    ├───►│ Dekripsi    ├───►│ Validasi    │────┐
                    │ AES-256     │    │ AES-256     │    │ Konteks     │    │
                    └─────────────┘    └─────────────┘    └─────────────┘    │
                                                                             │
                                                                             ▼
                                                                      ┌──────────────┐
                                                                      │ Output Data  │
                                                                      │ Terdekripsi  │
                                                                      └──────────────┘
```

## Implementasi di Kode

Berikut contoh implementasi untuk enkripsi dan dekripsi di ShopX:

```php
// Model menggunakan kedua trait untuk enkripsi
class PaymentMethod extends Model
{
    use Encryptable, EnhancedEncryptable;
    
    protected $encryptable = ['encrypted_details'];
    protected $enhancedEncryptable = ['cvv_enhanced'];
}

// Controller menerima input dan memproses enkripsi
public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'card_number' => 'required',
        'cvv' => 'required',
        'use_enhanced_security' => 'nullable|boolean',
    ]);
    
    // Standar enkripsi untuk detail kartu
    $details = [
        'card_number' => $request->card_number,
        'expiry_month' => $request->expiry_month,
        'expiry_year' => $request->expiry_year,
    ];
    
    $paymentMethod = new PaymentMethod();
    $paymentMethod->encrypted_details = json_encode($details);
    
    // Jika memilih keamanan tingkat lanjut, gunakan PBKDF2
    if ($request->use_enhanced_security) {
        $paymentMethod->cvv_enhanced = $request->cvv;
    }
    
    $paymentMethod->save();
}
```

## Kesimpulan

Sistem enkripsi dan dekripsi ShopX menyediakan keamanan multi-layer yang kuat untuk melindungi data sensitif pengguna. Dengan menggunakan kombinasi AES-256 dan PBKDF2, aplikasi mampu menawarkan perlindungan yang optimal bahkan untuk data yang sangat sensitif seperti CVV kartu kredit.

Arsitektur modular dan terstruktur memungkinkan pemeliharaan yang mudah dan skalabilitas untuk kebutuhan keamanan di masa depan, sementara pendekatan berbasis trait menyederhanakan implementasi di berbagai model data.
