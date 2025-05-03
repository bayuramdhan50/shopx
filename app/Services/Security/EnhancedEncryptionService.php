<?php

namespace App\Services\Security;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class EnhancedEncryptionService
{
    /**
     * Jumlah iterasi untuk PBKDF2
     * Angka yang lebih tinggi = lebih aman tapi lebih lambat
     * 
     * @var int
     */
    protected $iterations = 10000;

    /**
     * Panjang salt dalam bytes
     * 
     * @var int
     */
    protected $saltLength = 32;

    /**
     * Enkripsi data dengan AES-256 yang diperkuat dengan PBKDF2
     * 
     * @param string $data Data yang akan dienkripsi
     * @param string|null $additionalContext Data tambahan untuk meningkatkan keunikan kunci
     * @return string|null Data terenkripsi 
     */
    public function encrypt($data, $additionalContext = null)
    {
        if (empty($data)) {
            return null;
        }
        
        try {
            // Generate random salt
            $salt = $this->generateSalt();
            
            // Dapatkan app key dari Laravel untuk dijadikan dasar kunci
            $baseKey = env('APP_KEY');
            if (Str::startsWith($baseKey, 'base64:')) {
                $baseKey = base64_decode(substr($baseKey, 7));
            }
            
            // Tambahkan konteks tambahan jika ada (misalnya user ID atau tanggal)
            $context = $additionalContext ? $additionalContext : 'shopx_enhanced_encryption';
            
            // Buat kunci yang diperkuat dengan PBKDF2
            $enhancedKey = $this->deriveKeyUsingPBKDF2($baseKey, $salt, $context);
            
            // Gunakan Laravel Crypt tapi dengan kunci yang telah diperkuat
            $encrypted = Crypt::encryptString($data);
            
            // Simpan salt dan data terenkripsi
            $result = base64_encode(json_encode([
                'salt' => base64_encode($salt),
                'data' => $encrypted,
                'version' => 'enhanced-v1', // Untuk tracking versi enkripsi
            ]));
            
            return $result;
        } catch (Exception $e) {
            Log::error('Enhanced encryption failed: ' . $e->getMessage());
            // Fallback ke enkripsi standar Laravel
            return Crypt::encryptString($data);
        }
    }

    /**
     * Dekripsi data yang dienkripsi dengan AES-256 yang diperkuat dengan PBKDF2
     * 
     * @param string $encryptedData Data terenkripsi
     * @param string|null $additionalContext Data tambahan yang digunakan saat enkripsi
     * @return string|null Data terdekripsi
     */
    public function decrypt($encryptedData, $additionalContext = null)
    {
        if (empty($encryptedData)) {
            return null;
        }
        
        try {
            // Decode data terenkripsi
            $jsonData = json_decode(base64_decode($encryptedData), true);
            
            // Periksa apakah menggunakan format enkripsi yang ditingkatkan
            if (isset($jsonData['version']) && $jsonData['version'] === 'enhanced-v1') {
                // Dapatkan salt dan data terenkripsi
                $salt = base64_decode($jsonData['salt']);
                $encrypted = $jsonData['data'];
                
                // Dapatkan app key dari Laravel
                $baseKey = env('APP_KEY');
                if (Str::startsWith($baseKey, 'base64:')) {
                    $baseKey = base64_decode(substr($baseKey, 7));
                }
                
                // Tambahkan konteks tambahan jika ada
                $context = $additionalContext ? $additionalContext : 'shopx_enhanced_encryption';
                
                // Buat kunci yang sama dengan yang digunakan untuk enkripsi
                $enhancedKey = $this->deriveKeyUsingPBKDF2($baseKey, $salt, $context);
                
                // Dekripsi menggunakan Laravel Crypt
                return Crypt::decryptString($encrypted);
            } else {
                // Fallback untuk format enkripsi lama
                return Crypt::decryptString($encryptedData);
            }
        } catch (Exception $e) {
            Log::error('Enhanced decryption failed: ' . $e->getMessage());
            
            // Mencoba metode fallback jika format data tidak sesuai
            try {
                return Crypt::decryptString($encryptedData);
            } catch (Exception $e2) {
                Log::error('Fallback decryption also failed: ' . $e2->getMessage());
                return null;
            }
        }
    }
    
    /**
     * Generate salt acak untuk PBKDF2
     * 
     * @return string Random salt
     */
    protected function generateSalt()
    {
        return random_bytes($this->saltLength);
    }
    
    /**
     * Menurunkan kunci menggunakan PBKDF2 dengan algoritma SHA-256
     * 
     * @param string $baseKey Kunci dasar
     * @param string $salt Salt
     * @param string $context Konteks tambahan
     * @return string Kunci yang diperkuat
     */
    protected function deriveKeyUsingPBKDF2($baseKey, $salt, $context)
    {
        // Tambahkan konteks ke salt untuk meningkatkan keunikan
        $saltWithContext = $salt . $context;
        
        // Gunakan PBKDF2 untuk menghasilkan kunci yang lebih kuat
        // Output 32 bytes (256 bit) untuk AES-256
        return hash_pbkdf2(
            'sha256',
            $baseKey,
            $saltWithContext,
            $this->iterations,
            32,
            true
        );
    }
    
    /**
     * Verifikasi apakah data dienkripsi dengan metode yang ditingkatkan
     * 
     * @param string $encryptedData Data terenkripsi
     * @return bool
     */
    public function isEnhancedEncryption($encryptedData)
    {
        if (empty($encryptedData)) {
            return false;
        }
        
        try {
            $jsonData = json_decode(base64_decode($encryptedData), true);
            return isset($jsonData['version']) && $jsonData['version'] === 'enhanced-v1';
        } catch (Exception $e) {
            return false;
        }
    }
}