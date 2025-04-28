<?php

namespace App\Traits;

trait Encryptable
{
    public static function bootEncryptable()
    {
        static::saving(function ($model) {
            foreach ($model->getAttributes() as $key => $value) {
                if (!is_null($value) && is_string($value)) {
                    $model->$key = encrypt($value);
                }
            }
        });

        static::retrieved(function ($model) {
            foreach ($model->getAttributes() as $key => $value) {
                if (!is_null($value) && is_string($value)) {
                    try {
                        $model->$key = decrypt($value);
                    } catch (\Exception $e) {
                        // Do nothing if value was not encrypted
                    }
                }
            }
        });
    }
}
