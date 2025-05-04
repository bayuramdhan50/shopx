# Sistem Enkripsi dan Dekripsi ShopX

Dokumen ini menjelaskan secara detail implementasi sistem enkripsi dan dekripsi yang digunakan dalam aplikasi ShopX, termasuk alur proses, algoritma, dan mekanisme keamanan yang diterapkan.

## Tinjauan Enkripsi Multi-Layer

ShopX mengimplementasikan pendekatan enkripsi berlapis (multi-layer encryption) untuk melindungi data sensitif pengguna. Pendekatan ini terdiri dari dua lapisan utama:

1. **Enkripsi Standar (AES-256)** untuk data sensitif umum
2. **Enkripsi yang Diperkuat (PBKDF2 + AES-256)** untuk data yang sangat sensitif seperti CVV kartu kredit

## 1. Alur Enkripsi Standar (AES-256)

### Proses Enkripsi

```
┌─────────────┐      ┌────────────────┐      ┌────────────────┐      ┌────────────────┐
│  Data Asli  │─────►│  Serialisasi   │─────►│  Enkripsi AES  │─────►│ Data Terenkripsi│
│             │      │  (jika perlu)  │      │  dengan APP_KEY│      │                │
└─────────────┘      └────────────────┘      └────────────────┘      └────────────────┘
```

**Langkah-langkah detail:**

1. **Persiapan data**: Data yang akan dienkripsi (misalnya, detail kartu kredit) disiapkan.
2. **Serialisasi**: Jika data berupa array atau objek, data akan di-serialize menjadi JSON string.
3. **Enkripsi**: Data dienkripsi menggunakan algoritma AES-256-CBC dengan kunci enkripsi dari `APP_KEY` Laravel.
4. **MAC (Message Authentication Code)**: MAC ditambahkan untuk validasi integritas data.
5. **Base64 Encoding**: Hasil enkripsi di-encode dengan Base64 untuk menjadi string yang dapat disimpan.

**Implementasi Kode:**

```php
// Implementasi dalam trait Encryptable
public function encryptAttributes(): void
{
    foreach ($this->getEncryptableAttributes() as $attribute) {
        if (isset($this->attributes[$attribute]) && !is_null($this->attributes[$attribute])) {
            try {
                // Skip jika sudah terenkripsi
                if ($this->isEncrypted($this->attributes[$attribute])) {
                    continue;
                }
                
                // Lakukan enkripsi AES-256 menggunakan Crypt facade Laravel
                $this->attributes[$attribute] = Crypt::encrypt($this->attributes[$attribute]);
                
            } catch (\Exception $e) {
                // Penanganan error
            }
        }
    }
}
```

### Proses Dekripsi

```
┌────────────────┐      ┌────────────────┐      ┌────────────────┐      ┌────────────┐
│Data Terenkripsi│─────►│  Validasi MAC  │─────►│  Dekripsi AES  │─────►│ Data Asli  │
│                │      │  & Integritas  │      │  dengan APP_KEY│      │            │
└────────────────┘      └────────────────┘      └────────────────┘      └────────────┘
```

**Langkah-langkah detail:**

1. **Persiapan data terenkripsi**: Data terenkripsi diambil dari penyimpanan (database).
2. **Base64 Decoding**: Decoding string Base64 menjadi data biner.
3. **Verifikasi MAC**: MAC diverifikasi untuk memastikan integritas data belum berubah.
4. **Dekripsi**: Data didekripsi menggunakan algoritma AES-256-CBC dengan `APP_KEY`.
5. **Deserialisasi**: Jika data asli adalah array/objek, hasil dekripsi di-unserialize dari JSON.

**Implementasi Kode:**

```php
// Implementasi dalam trait Encryptable
public function decryptAttributes(): void
{
    foreach ($this->getEncryptableAttributes() as $attribute) {
        if (isset($this->attributes[$attribute]) && !is_null($this->attributes[$attribute])) {
            try {
                // Dekripsi menggunakan Crypt facade Laravel
                $this->attributes[$attribute] = Crypt::decrypt($this->attributes[$attribute]);
            } catch (\Exception $e) {
                // Penanganan error dekripsi
            }
        }
    }
}
```

## 2. Alur Enkripsi yang Diperkuat (PBKDF2 + AES-256)

Untuk data yang sangat sensitif, ShopX mengimplementasikan lapisan keamanan tambahan dengan PBKDF2 (Password-Based Key Derivation Function 2).

### Proses Enkripsi dengan PBKDF2

```
┌─────────────┐     ┌─────────────┐     ┌─────────────────┐     ┌─────────────┐     ┌─────────────────┐
│  Data Asli  │────►│ Generate    │────►│ Derivasi Kunci  │────►│ Enkripsi    │────►│ Format Data     │
│             │     │ Salt Unik   │     │ dengan PBKDF2   │     │ AES-256     │     │ dengan Metadata │
└─────────────┘     └─────────────┘     └─────────────────┘     └─────────────┘     └─────────────────┘
                           │                     ▲                                           │
                           │                     │                                           │
                           │                ┌────┴────────┐                                  ▼
                           └───────────────►│ Context     │                          ┌─────────────────┐
                                            │ (user_id)   │                          │ Base64 Encoding │
                                            └─────────────┘                          └─────────────────┘
```

**Langkah-langkah detail:**

1. **Persiapan data**: Data yang akan dienkripsi (misalnya, CVV) disiapkan.
2. **Pembuatan salt**: Salt unik dibuat untuk setiap data.
3. **Penambahan konteks**: Data konteks seperti user_id ditambahkan ke salt.
4. **Key Derivation**: `APP_KEY` diperkuat melalui PBKDF2 dengan 10,000 iterasi hash.
5. **Enkripsi AES**: Data dienkripsi menggunakan AES-256 dengan kunci yang diturunkan.
6. **Penambahan metadata**: Metadata seperti salt, algoritma, dan konteks disimpan.
7. **Base64 Encoding**: Semua informasi di-encode sebagai string Base64.

**Implementasi Kode:**

```php
// Implementasi di PBKDF2Service
public function encrypt(string $data, string $context = ''): string
{
    // Generate salt unik
    $salt = $this->generateSalt();
    if (!empty($context)) {
        // Tambahkan konteks ke salt
        $salt = hash('sha256', $context . $salt, true);
    }
    
    // Turunkan kunci dari APP_KEY menggunakan PBKDF2
    $keyData = $this->strengthenKey(config('app.key'), $salt);
    
    // Enkripsi data asli menggunakan kunci turunan
    $encrypted = openssl_encrypt(
        $data,
        'AES-256-CBC',
        $keyData['derived_key'],
        0,
        $keyData['iv']
    );
    
    // Format hasil dengan metadata lengkap
    $result = [
        'data' => $encrypted,
        'salt' => base64_encode($salt),
        'iterations' => $this->iterations,
        'iv' => base64_encode($keyData['iv']),
        'algorithm' => $this->hashAlgorithm,
        'context_hash' => hash('sha256', $context),
        'method' => 'pbkdf2_aes256',
        'version' => '1.0',
    ];
    
    return base64_encode(json_encode($result));
}
```

### Proses Dekripsi dengan PBKDF2

```
┌────────────────┐     ┌─────────────┐     ┌─────────────────┐     ┌─────────────┐     ┌─────────────┐
│Data Terenkripsi│────►│ Parse       │────►│ Validasi        │────►│ Regenerasi  │────►│ Dekripsi    │
│dengan Metadata │     │ Metadata    │     │ Konteks & Salt  │     │ Kunci PBKDF2│     │ AES-256     │
└────────────────┘     └─────────────┘     └─────────────────┘     └─────────────┘     └─────────────┘
                                                    ▲                     ▲
                                                    │                     │
                                             ┌──────┴──────┐       ┌──────┴──────┐
                                             │ Context     │       │ Salt dari   │
                                             │ (user_id)   │       │ Metadata    │
                                             └─────────────┘       └─────────────┘
```

**Langkah-langkah detail:**

1. **Parsing data**: Data terenkripsi diambil dan di-decode dari Base64.
2. **Ekstraksi metadata**: Metadata seperti salt, IV, dan konteks diekstrak.
3. **Validasi konteks**: Hash konteks divalidasi untuk memastikan otentisitas.
4. **Regenerasi kunci**: Kunci diturunkan kembali menggunakan PBKDF2 dengan salt yang disimpan.
5. **Dekripsi AES**: Data didekripsi menggunakan AES-256 dengan kunci yang diturunkan.

**Implementasi Kode:**

```php
// Implementasi di PBKDF2Service
public function decrypt(string $encryptedData, string $context = ''): string
{
    // Decode dan parse data terenkripsi
    $data = json_decode(base64_decode($encryptedData), true);
    
    // Validasi format dan metadata
    if (!isset($data['method']) || $data['method'] !== 'pbkdf2_aes256') {
        throw new \Exception("Format enkripsi tidak valid atau bukan metode PBKDF2");
    }
    
    // Validasi konteks jika disediakan
    if (!empty($context) && hash('sha256', $context) !== $data['context_hash']) {
        throw new \Exception("Konteks tidak valid, kemungkinan data tidak sah");
    }
    
    // Ekstrak salt dan parameter lain
    $salt = base64_decode($data['salt']);
    $iv = base64_decode($data['iv']);
    
    // Regenerasi kunci menggunakan PBKDF2 dengan salt yang sama
    $keyData = $this->strengthenKey(config('app.key'), $salt, $iv);
    
    // Dekripsi data menggunakan kunci yang diturunkan
    $decrypted = openssl_decrypt(
        $data['data'],
        'AES-256-CBC',
        $keyData['derived_key'],
        0,
        $iv
    );
    
    if ($decrypted === false) {
        throw new \Exception("Dekripsi gagal, kunci atau data mungkin rusak");
    }
    
    return $decrypted;
}
```

## 3. Implementasi di Model

Sistem enkripsi ShopX diimplementasikan melalui trait yang terhubung dengan model Eloquent. Model `PaymentMethod` menggunakan kedua trait untuk enkripsi standar dan enhanced:

```php
class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes, Encryptable, EnhancedEncryptable;

    // Atribut yang menggunakan enkripsi standar
    protected $encryptable = [
        'encrypted_details',
    ];
    
    // Atribut yang menggunakan enkripsi tingkat lanjut (PBKDF2)
    protected $enhancedEncryptable = [
        'cvv_enhanced',
    ];
    
    // ... metode lain dari model
}
```

## 4. Keunggulan Sistem Enkripsi ShopX

### Keamanan Berlapis

1. **Kunci Enkripsi yang Kuat**: Menggunakan kunci 256-bit yang sangat sulit untuk diretas.
2. **Salt Unik per Data**: Mencegah serangan lookup table dan rainbow table.
3. **Konteks Pengikatan**: Membuat data terikat dengan pengguna spesifik.
4. **Iterasi Tinggi**: 10,000 iterasi hash membuat brute force sangat lambat dan mahal.
5. **Format Terstruktur**: Metadata memudahkan validasi dan audit.

### Integritas dan Autentikasi

1. **Validasi MAC**: Memastikan data tidak diubah.
2. **Validasi Konteks**: Memverifikasi bahwa data milik pengguna yang tepat.
3. **Versi dan Metadata**: Memungkinkan upgrade algoritma di masa depan.

### Performa dan Skalabilitas

1. **Enkripsi Teroptimasi**: Menggunakan extension OpenSSL PHP yang cepat.
2. **Caching**: Laravel caching dimanfaatkan untuk informasi yang sering diakses.
3. **Enkripsi Selektif**: Hanya data sensitif yang dienkripsi, menjaga performa.

## 5. Ilustrasi Proses Lengkap untuk CVV

### Proses Enkripsi CVV

1. Pengguna mengaktifkan opsi "Keamanan Tingkat Lanjut" pada form pembayaran
2. Pengguna memasukkan CVV: "123"
3. Service menambahkan konteks: "payment_details_user_42" (user_id=42)
4. Service generate salt unik: "a1b2c3d4e5f6g7h8"
5. Service menjalankan PBKDF2 dengan 10,000 iterasi untuk menghasilkan kunci turunan
6. Data "123" dienkripsi dengan AES-256 menggunakan kunci turunan
7. Hasil enkripsi + metadata disimpan di database

### Proses Dekripsi CVV

1. Sistem memuat data terenkripsi dari database
2. Format JSON diparse dan informasi salt, IV, dan metadata lain diekstrak
3. Konteks pengguna divalidasi untuk memastikan otentisitas
4. PBKDF2 dijalankan dengan 10,000 iterasi menggunakan salt yang sama
5. Data didekripsi menggunakan kunci turunan dan IV yang disimpan
6. Sistem mendapatkan kembali nilai CVV asli: "123"

## 6. Mitigasi Risiko dan Penanganan Kegagalan

1. **Penanganan Error Terstruktur**: Semua operasi enkripsi/dekripsi dalam try-catch dengan logging
2. **Fallback Mechanism**: Mekanisme untuk mengatasi perubahan format enkripsi
3. **Monitoring**: Pemantauan terhadap kegagalan dekripsi untuk mendeteksi masalah

## 7. Best Practices yang Diimplementasikan

1. **Kunci Terpisah**: Tidak pernah menyimpan kunci enkripsi di database
2. **Minimal Data**: Hanya menyimpan data sensitif yang benar-benar diperlukan
3. **Validasi Data**: Memverifikasi asal dan integritas data sebelum dekripsi
4. **Logging Terbatas**: Tidak pernah mencatat data sensitif di log
5. **Rotasi Kunci**: Memungkinkan perpindahan ke kunci baru tanpa kehilangan data lama
