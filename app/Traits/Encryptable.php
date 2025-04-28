<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

trait Encryptable
{
    /**
     * Boot the encryptable trait for a model.
     */
    public static function bootEncryptable(): void
    {
        static::saving(function ($model) {
            $model->encryptAttributes();
        });

        static::retrieved(function ($model) {
            $model->decryptAttributes();
        });
    }

    /**
     * Get the array of attributes that should be encrypted
     * 
     * @return array<string>
     */
    protected function getEncryptableAttributes(): array
    {
        return property_exists($this, 'encryptable') ? $this->encryptable : [];
    }

    /**
     * Encrypt the encryptable attributes
     */
    public function encryptAttributes(): void
    {
        foreach ($this->getEncryptableAttributes() as $attribute) {
            if (isset($this->attributes[$attribute]) && !is_null($this->attributes[$attribute])) {
                try {
                    // Skip if already encrypted (prevents double encryption)
                    if ($this->isEncrypted($this->attributes[$attribute])) {
                        Log::info('Attribute already encrypted, skipping: ' . $attribute);
                        continue;
                    }
                    
                    $this->attributes[$attribute] = Crypt::encrypt($this->attributes[$attribute]);
                    Log::info('Successfully encrypted attribute: ' . $attribute);
                } catch (\Exception $e) {
                    Log::error('Failed to encrypt attribute: ' . $attribute, [
                        'error' => $e->getMessage(),
                        'model' => get_class($this),
                        'id' => $this->id ?? 'new'
                    ]);
                }
            }
        }
    }

    /**
     * Decrypt the encryptable attributes
     */
    public function decryptAttributes(): void
    {
        foreach ($this->getEncryptableAttributes() as $attribute) {
            if (isset($this->attributes[$attribute]) && !is_null($this->attributes[$attribute])) {
                try {
                    $this->attributes[$attribute] = Crypt::decrypt($this->attributes[$attribute]);
                } catch (\Exception $e) {
                    Log::warning('Failed to decrypt attribute: ' . $attribute, [
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
     * Override the getAttribute method to decrypt on-the-fly
     * 
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        // Skip password field to avoid interfering with authentication
        if ($key === 'password') {
            return $value;
        }
        
        if (in_array($key, $this->getEncryptableAttributes()) && !is_null($value)) {
            try {
                return Crypt::decrypt($value);
            } catch (\Exception $e) {
                return $value;
            }
        }
        
        return $value;
    }

    /**
     * Override the setAttribute method to encrypt on-the-fly
     * 
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // Skip password field to avoid interfering with authentication
        if ($key === 'password') {
            return parent::setAttribute($key, $value);
        }
        
        if (in_array($key, $this->getEncryptableAttributes()) && !is_null($value)) {
            // Only encrypt if not already encrypted
            if (!$this->isEncrypted($value)) {
                $value = Crypt::encrypt($value);
            }
        }
        
        return parent::setAttribute($key, $value);
    }
    
    /**
     * Check if a value is already encrypted
     * 
     * @param mixed $value
     * @return bool
     */
    protected function isEncrypted($value): bool
    {
        if (!is_string($value)) {
            return false;
        }
        
        // Check if it looks like a serialized encrypted Laravel value
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $value) && mb_strlen($value) > 40) {
            try {
                // Try to decrypt it - if it works, it was encrypted
                Crypt::decrypt($value);
                return true;
            } catch (\Exception $e) {
                // If decryption fails, it wasn't encrypted
                return false;
            }
        }
        
        return false;
    }
}
