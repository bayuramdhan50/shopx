<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

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
                $this->attributes[$attribute] = Crypt::encrypt($this->attributes[$attribute]);
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
                    // Do nothing if value was not encrypted
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
        if (in_array($key, $this->getEncryptableAttributes()) && !is_null($value)) {
            $value = Crypt::encrypt($value);
        }
        
        return parent::setAttribute($key, $value);
    }
}
