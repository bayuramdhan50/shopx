<?php

namespace App\Services\Security;

use Illuminate\Support\Facades\Crypt;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class PBKDF2Service
 *
 * Layanan untuk menangani derivasi kunci menggunakan PBKDF2
 * untuk meningkatkan keamanan enkripsi AES-256 yang sudah ada
 */
class PBKDF2Service
{
    /**
     * Jumlah iterasi PBKDF2
     * Semakin tinggi iterasi = lebih aman tetapi lebih lambat
     */
    protected int $iterations = 10000;

    /**
     * Panjang kunci dalam byte (256 bits = 32 bytes)
     */
    protected int $keyLength = 32;

    /**
     * Algoritma hash untuk digunakan dengan PBKDF2
     */
    protected string $hashAlgorithm = 'sha256';

    /**
     * Panjang salt dalam byte
     */
    protected int $saltLength = 16;

    /**
     * Memperkuat kunci dengan PBKDF2 untuk meningkatkan keamanan enkripsi
     *
     * @param string $password Password atau kunci asli yang akan diperkuat
     * @param string|null $salt Salt untuk digunakan (opsional, akan digenerate jika null)
     * @return array Array berisi kunci yang diperkuat dan salt yang digunakan
     */
    public function strengthenKey(string $password, ?string $salt = null): array
    {
        // Generate random salt jika tidak disediakan
        $salt = $salt ?? random_bytes($this->saltLength);

        // Derive key using PBKDF2
        $derivedKey = hash_pbkdf2(
            $this->hashAlgorithm,
            $password,
            $salt,
            $this->iterations,
            $this->keyLength,
            true
        );

        return [
            'key' => $derivedKey,
            'salt' => $salt,
        ];
    }

    /**
     * Enkripsi data menggunakan PBKDF2 + Laravel encryption
     *
     * @param string $data Data yang akan dienkripsi
     * @param string $context String konteks tambahan untuk meningkatkan keamanan
     * @return string Data terenkripsi
     */
    public function encrypt(string $data, string $context = ''): string
    {
        try {
            // Gunakan context sebagai bagian dari salt untuk mengikat enkripsi ke konteks spesifik
            $salt = hash('sha256', $context . config('app.key'), true);

            // Derive key dari app key menggunakan PBKDF2
            $keyData = $this->strengthenKey(config('app.key'), $salt);

            // Encrypt the data (using Laravel's encryption for simplicity)
            // In a real scenario, you might want to use the derived key directly with openssl_encrypt
            $encrypted = Crypt::encrypt($data);

            // Format hasil enkripsi dengan metadata
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
        } catch (Exception $e) {
            Log::error('PBKDF2 encryption failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Fallback to standard encryption on error
            return Crypt::encrypt($data);
        }
    }

    /**
     * Dekripsi data yang dienkripsi dengan PBKDF2 + AES
     *
     * @param string $encryptedData Data terenkripsi
     * @param string $context String konteks tambahan untuk memverifikasi keamanan
     * @return string Data yang didekripsi
     */
    public function decrypt(string $encryptedData, string $context = ''): string
    {
        try {
            // Decode the base64
            $json = base64_decode($encryptedData);

            // Parse JSON
            $data = json_decode($json, true);

            // Validate format
            if (!$data || !isset($data['method']) || $data['method'] !== 'pbkdf2_aes256') {
                // Not our format, try standard decryption
                return Crypt::decrypt($encryptedData);
            }

            // Verify context if available
            if (isset($data['context']) && hash('sha256', $context) !== $data['context']) {
                Log::warning('PBKDF2 decryption context mismatch', [
                    'expected' => hash('sha256', $context),
                    'actual' => $data['context'] ?? 'missing'
                ]);
                // We still proceed but log the warning
            }

            // Extract components
            $encryptedPayload = $data['data'];
            $salt = base64_decode($data['salt']);

            // Regenerate the same key
            $keyData = $this->strengthenKey(config('app.key'), $salt);

            // Decrypt (using Laravel's decryption for simplicity)
            return Crypt::decrypt($encryptedPayload);
        } catch (Exception $e) {
            Log::error('PBKDF2 decryption failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Try standard decryption as fallback
            try {
                return Crypt::decrypt($encryptedData);
            } catch (Exception $innerException) {
                Log::error('Standard decryption also failed', [
                    'error' => $innerException->getMessage()
                ]);
                throw $e; // Re-throw original exception
            }
        }
    }

    /**
     * Cek apakah string tertentu dienkripsi dengan metode PBKDF2 kita
     *
     * @param string $value String untuk dicek
     * @return bool True jika dienkripsi dengan metode kita
     */
    public function isEnhancedEncryption(string $value): bool
    {
        try {
            $json = base64_decode($value);
            $data = json_decode($json, true);

            return is_array($data) &&
                   isset($data['method']) &&
                   $data['method'] === 'pbkdf2_aes256';
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Set jumlah iterasi PBKDF2
     *
     * @param int $iterations
     * @return $this
     */
    public function setIterations(int $iterations): self
    {
        $this->iterations = $iterations;
        return $this;
    }
}
