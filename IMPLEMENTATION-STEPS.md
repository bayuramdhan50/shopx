# Langkah-Langkah Implementasi PBKDF2 + AES-256 di ShopX

Dokumen ini berisi panduan implementasi teknis tentang bagaimana PBKDF2 (Password-Based Key Derivation Function 2) ditambahkan ke ShopX untuk memperkuat mekanisme enkripsi AES-256 yang sudah ada.

## 1. Persiapan Implementasi

### 1.1. Analisis Kebutuhan

Sistem ShopX sudah menggunakan enkripsi AES-256 melalui Laravel's built-in encryption, tetapi untuk memperkuat keamanan data yang sangat sensitif (seperti CVV kartu kredit), PBKDF2 diimplementasikan sebagai layer tambahan:

- **Tujuan**: Meningkatkan resistensi terhadap serangan brute force pada kunci enkripsi
- **Data target**: Terutama CVV kartu pembayaran
- **Pendekatan**: Menggunakan PBKDF2 untuk derivasi kunci dari master key sebelum enkripsi AES-256

### 1.2. Struktur Database

Perubahan database berikut diperlukan:

```php
// Migrasi: add_enhanced_encryption_to_payment_methods.php
Schema::table('payment_methods', function (Blueprint $table) {
    // Tambahkan kolom baru untuk menyimpan CVV yang dienkripsi dengan PBKDF2 + AES-256
    $table->text('cvv_enhanced')->nullable()->after('encrypted_details');
});
```

## 2. Implementasi PBKDF2Service

Layanan `PBKDF2Service` dibuat untuk menangani proses derivasi kunci dan enkripsi/dekripsi:

```php
namespace App\Services\Security;

class PBKDF2Service
{
    protected int $iterations = 10000;
    protected int $keyLength = 32;
    protected string $hashAlgorithm = 'sha256';
    protected int $saltLength = 16;

    // Fungsi untuk memperkuat kunci dengan PBKDF2
    public function encrypt(string $data, string $context = ''): string
    {
        // Gunakan konteks sebagai bagian dari salt
        $salt = hash('sha256', $context . config('app.key'), true);
        
        // Derive key dari app key menggunakan PBKDF2
        $keyData = $this->strengthenKey(config('app.key'), $salt);
        
        // Encrypt data
        $encrypted = Crypt::encrypt($data);
        
        // Format hasil dengan metadata
        $result = [
            'data' => $encrypted,
            'salt' => base64_encode($keyData['salt']),
            'iterations' => $this->iterations,
            'algorithm' => $this->hashAlgorithm,
            'context' => hash('sha256', $context),
            'method' => 'pbkdf2_aes256',
            'version' => '1.0',
        ];
        
        return base64_encode(json_encode($result));
    }

    // Dekripsi data dengan verifikasi konteks
    public function decrypt(string $encryptedData, string $context = ''): string
    {
        // Implementasi dekripsi
    }
}
```

## 3. Model dan Trait

Untuk mendukung implementasi PBKDF2, dua trait dibuat:

### 3.1. Trait EnhancedEncryptable

```php
trait EnhancedEncryptable
{
    // Boot trait untuk mengatur event listeners
    public static function bootEnhancedEncryptable(): void
    {
        static::saving(function ($model) {
            $model->encryptEnhancedAttributes();
        });

        static::retrieved(function ($model) {
            $model->decryptEnhancedAttributes();
        });
    }

    // Mendapatkan atribut yang perlu enkripsi tingkat lanjut
    protected function getEnhancedEncryptableAttributes(): array
    {
        return property_exists($this, 'enhancedEncryptable') ? $this->enhancedEncryptable : [];
    }
    
    // Implementasi enkripsi/dekripsi
    // ...
}
```

### 3.2. Implementasi di Model PaymentMethod

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
    
    // Metode accessor dan mutator untuk menangani enkripsi/dekripsi
    // ...
}
```

## 4. Form dan Controller

Form pembayaran diperbarui untuk mendukung opsi keamanan tingkat lanjut:

```html
<div class="flex items-start">
    <div class="flex items-center h-5">
        <input type="hidden" name="use_enhanced_security" value="0">
        <input id="use_enhanced_security" name="use_enhanced_security" type="checkbox" value="1">
    </div>
    <div class="ml-3 text-sm">
        <label for="use_enhanced_security">
            Gunakan keamanan tingkat lanjut
        </label>
        <p class="text-gray-500">
            CVV Anda akan disimpan dengan enkripsi ganda menggunakan PBKDF2 + AES-256
        </p>
    </div>
</div>
```

Controller diperbarui untuk menangani opsi keamanan lanjutan:

```php
// Validasi input
$request->validate([
    // ...
    'use_enhanced_security' => 'nullable|in:0,1,true,false,on',
    'cvv_enhanced' => 'required_if:use_enhanced_security,1,true,on|string|min:3|max:4',
    // ...
]);

// Menangani enkripsi lanjutan jika dipilih
$useEnhancedSecurity = in_array($request->use_enhanced_security, [1, '1', true, 'true', 'on'], true);
if ($useEnhancedSecurity && in_array($request->type, ['credit_card', 'debit_card'])) {
    $paymentMethod->cvv_enhanced = $request->cvv_enhanced;
}
```

## 5. Dashboard Admin Keamanan

Dashboard admin dibuat untuk memonitor keamanan dan metode enkripsi:

```php
class SecurityDashboard extends Page
{
    public function getViewData(): array
    {
        return [
            'encryptedMethodsCount' => PaymentMethod::count(),
            'enhancedEncryptedCount' => PaymentMethod::whereNotNull('cvv_enhanced')->count(),
            'encryptionAlgorithms' => [
                // Informasi algoritma enkripsi
            ],
            // Statistik keamanan lainnya
        ];
    }
}
```

## 6. Pengujian Implementasi

Untuk memverifikasi implementasi PBKDF2 + AES-256, ikuti langkah-langkah berikut:

1. **Test Enkripsi**: Buat metode pembayaran dengan opsi keamanan tingkat lanjut diaktifkan
2. **Test Dekripsi**: Pastikan data dapat didekripsi dengan benar saat diakses
3. **Test Ketahanan**: Simulasikan serangan menggunakan input yang tidak valid
4. **Test Performa**: Ukur overhead performa dari implementasi PBKDF2

## 7. Mitigasi Risiko dan Maintenance

- **Key Rotation**: Perbarui kunci master secara berkala
- **Salt Management**: Pastikan salt tidak dapat diprediksi
- **Monitoring**: Pantau upaya akses yang tidak sah ke data terenkripsi
- **Versi Baru**: Perbarui implementasi jika ada kelemahan ditemukan di PBKDF2

## Referensi

- [OWASP Cryptographic Storage Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Cryptographic_Storage_Cheat_Sheet.html)
- [NIST Recommendations for Key Derivation](https://nvlpubs.nist.gov/nistpubs/Legacy/SP/nistspecialpublication800-132.pdf)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
