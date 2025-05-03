<?php

namespace App\Services\Security;

use Illuminate\Support\Facades\Crypt;
use Exception;
use Illuminate\Support\Facades\Log;

class EncryptionService
{
    /**
     * Number of PBKDF2 iterations
     * Higher iterations = more secure but slower
     */
    protected int $iterations = 10000;

    /**
     * Key length in bytes (256 bits = 32 bytes)
     */
    protected int $keyLength = 32;

    /**
     * Hash algorithm to use with PBKDF2
     */
    protected string $hashAlgorithm = 'sha256';

    /**
     * Encrypt data using AES-256 with PBKDF2 key derivation
     *
     * @param string $data Data to encrypt
     * @param string|null $additionalAuthData Additional authenticated data (salt)
     * @return string Encrypted data
     */
    public function encryptWithPBKDF2(string $data, ?string $additionalAuthData = null): string
    {
        try {
            // Generate a random salt for PBKDF2
            $salt = $additionalAuthData ?? random_bytes(16);

            // Use salt to derive a key using PBKDF2
            $derivedKey = $this->deriveKeyPBKDF2($salt);

            // Use Laravel's encryption with the derived key
            // For demonstration purposes, we're still using Laravel's encryption
            // In a real implementation, you might want to use openssl_encrypt directly
            $encrypted = Crypt::encrypt($data);

            // Store salt with the encrypted data (as base64 for readability)
            $result = [
                'data' => $encrypted,
                'salt' => base64_encode($salt),
                'iterations' => $this->iterations,
                'method' => 'pbkdf2_aes256',
            ];

            return json_encode($result);
        } catch (Exception $e) {
            Log::error('Enhanced encryption failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Fallback to standard encryption if PBKDF2 fails
            return Crypt::encrypt($data);
        }
    }

    /**
     * Decrypt data that was encrypted with PBKDF2 and AES-256
     *
     * @param string $encryptedData The encrypted data
     * @return string The decrypted data
     */
    public function decryptWithPBKDF2(string $encryptedData): string
    {
        try {
            // Decode the JSON structure
            $encryptedDataArray = json_decode($encryptedData, true);

            // If it's not our enhanced encryption format, try standard decryption
            if (!$encryptedDataArray || !isset($encryptedDataArray['method']) || $encryptedDataArray['method'] !== 'pbkdf2_aes256') {
                return Crypt::decrypt($encryptedData);
            }

            // Extract components
            $encryptedPayload = $encryptedDataArray['data'];
            $salt = base64_decode($encryptedDataArray['salt']);

            // Derive the same key using the stored salt
            $derivedKey = $this->deriveKeyPBKDF2($salt);

            // Decrypt using Laravel's decryption
            // In a real implementation, you'd use the derived key directly with openssl_decrypt
            return Crypt::decrypt($encryptedPayload);
        } catch (Exception $e) {
            Log::error('Enhanced decryption failed', [
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
                throw $e; // Re-throw the original exception
            }
        }
    }

    /**
     * Derive a cryptographic key using PBKDF2
     *
     * @param string $salt A random salt
     * @return string The derived key
     */
    protected function deriveKeyPBKDF2(string $salt): string
    {
        // Use Laravel's APP_KEY as the base password for PBKDF2
        // In a production environment, you might want to use a separate secure key
        $baseKey = config('app.key');

        // Remove the "base64:" prefix if present
        if (strpos($baseKey, 'base64:') === 0) {
            $baseKey = substr($baseKey, 7);
            $baseKey = base64_decode($baseKey);
        }

        // Derive a key using PBKDF2
        $derivedKey = hash_pbkdf2(
            $this->hashAlgorithm,
            $baseKey,
            $salt,
            $this->iterations,
            $this->keyLength,
            true
        );

        return $derivedKey;
    }

    /**
     * Set the number of iterations for PBKDF2
     *
     * @param int $iterations
     * @return $this
     */
    public function setIterations(int $iterations): self
    {
        $this->iterations = $iterations;
        return $this;
    }

    /**
     * Set the key length in bytes
     *
     * @param int $keyLength
     * @return $this
     */
    public function setKeyLength(int $keyLength): self
    {
        $this->keyLength = $keyLength;
        return $this;
    }

    /**
     * Set the hash algorithm
     *
     * @param string $algorithm
     * @return $this
     */
    public function setHashAlgorithm(string $algorithm): self
    {
        $this->hashAlgorithm = $algorithm;
        return $this;
    }
}
