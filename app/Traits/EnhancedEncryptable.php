<?php

namespace App\Traits;

use App\Services\Security\PBKDF2Service;
use Illuminate\Support\Facades\Log;

trait EnhancedEncryptable
{
    /**
     * Boot the enhanced encryptable trait for a model.
     */
    public static function bootEnhancedEncryptable(): void
    {
        static::saving(function ($model) {
            $model->encryptEnhancedAttributes();
        });

        static::retrieved(function ($model) {
            $model->decryptEnhancedAttributes();
        });
    }

    /**
     * Get the array of attributes that should be encrypted with enhanced security
     *
     * @return array<string>
     */
    protected function getEnhancedEncryptableAttributes(): array
    {
        return property_exists($this, 'enhancedEncryptable') ? $this->enhancedEncryptable : [];
    }

    /**
     * Encrypt the enhanced encryptable attributes using PBKDF2 + AES-256
     */
    public function encryptEnhancedAttributes(): void
    {
        $encryptionService = app(PBKDF2Service::class);

        foreach ($this->getEnhancedEncryptableAttributes() as $attribute) {
            if (isset($this->attributes[$attribute]) && !is_null($this->attributes[$attribute])) {
                try {
                    // Use the model's primary key as additional authentication data (salt)
                    // This ties the encryption to this specific record
                    $additionalAuthData = $this->exists ? (string)$this->getKey() : null;

                    // Skip if already encrypted
                    if ($this->isEnhancedEncrypted($this->attributes[$attribute])) {
                        Log::info('Attribute already encrypted with enhanced security, skipping: ' . $attribute);
                        continue;
                    }

                    $this->attributes[$attribute] = $encryptionService->encryptWithPBKDF2(
                        $this->attributes[$attribute],
                        $additionalAuthData
                    );

                    Log::info('Successfully encrypted attribute with enhanced security: ' . $attribute);
                } catch (\Exception $e) {
                    Log::error('Failed to encrypt attribute with enhanced security: ' . $attribute, [
                        'error' => $e->getMessage(),
                        'model' => get_class($this),
                        'id' => $this->id ?? 'new'
                    ]);
                }
            }
        }
    }

    /**
     * Decrypt the enhanced encryptable attributes     */
    public function decryptEnhancedAttributes(): void
    {
        $encryptionService = app(PBKDF2Service::class);

        foreach ($this->getEnhancedEncryptableAttributes() as $attribute) {
            if (isset($this->attributes[$attribute]) && !is_null($this->attributes[$attribute])) {
                try {
                    $this->attributes[$attribute] = $encryptionService->decrypt($this->attributes[$attribute]);
                } catch (\Exception $e) {
                    Log::warning('Failed to decrypt attribute with enhanced security: ' . $attribute, [
                        'error' => $e->getMessage(),
                        'model' => get_class($this),
                        'id' => $this->id ?? 'unknown'
                    ]);
                    // Keep the original value if decryption fails
                }
            }
        }
    }

    /**
     * Check if a string is already encrypted with our enhanced encryption
     *
     * @param string $value
     * @return bool
     */
    protected function isEnhancedEncrypted(string $value): bool
    {
        try {
            $pbkdf2Service = app(PBKDF2Service::class);
            return $pbkdf2Service->isEnhancedEncryption($value);
        } catch (\Exception $e) {
            return false;
        }
    }
}
