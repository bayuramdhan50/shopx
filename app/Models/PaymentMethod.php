<?php

namespace App\Models;

use App\Services\Security\EnhancedEncryptionService;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes, Encryptable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'encrypted_details',
        'is_default',
    ];    
    
    /**
     * Layanan enkripsi yang ditingkatkan.
     * 
     * @var EnhancedEncryptionService|null
     */
    protected $enhancedEncryption = null;
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            Log::info('Creating new payment method', [
                'user_id' => $model->user_id,
                'name' => $model->name,
                'type' => $model->type
            ]);
        });

        static::created(function ($model) {
            Log::info('Payment method created successfully', [
                'id' => $model->id,
                'user_id' => $model->user_id
            ]);
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * The attributes that should be encrypted.
     *
     * @var array<string>
     */
    protected $encryptable = [
        'encrypted_details',
    ];
    
    /**
     * Override metode setEncryptedDetailsAttribute untuk menggunakan enkripsi yang diperkuat.
     * 
     * @param string $value
     * @return void
     */
    public function setEncryptedDetailsAttribute($value)
    {
        // Hanya enkripsi jika nilai tidak kosong
        if (!empty($value)) {
            // Gunakan enkripsi yang ditingkatkan untuk data pembayaran yang sensitif
            $encryptor = $this->getEnhancedEncryption();
            
            // Tambahkan user_id sebagai konteks tambahan untuk meningkatkan keamanan
            $context = "payment_details_user_" . $this->user_id;
            
            // Enkripsi data dengan metode yang diperkuat
            $this->attributes['encrypted_details'] = $encryptor->encrypt($value, $context);
        } else {
            $this->attributes['encrypted_details'] = $value;
        }
    }
    
    /**
     * Override metode getEncryptedDetailsAttribute untuk mendekripsi data dengan metode yang tepat.
     * 
     * @param string $value
     * @return string
     */
    public function getEncryptedDetailsAttribute($value)
    {
        // Jika nilai kosong, kembalikan apa adanya
        if (empty($value)) {
            return $value;
        }
        
        $encryptor = $this->getEnhancedEncryption();
        
        // Cek apakah data dienkripsi dengan metode yang ditingkatkan
        if ($encryptor->isEnhancedEncryption($value)) {
            // Dekripsi dengan metode yang ditingkatkan
            $context = "payment_details_user_" . $this->user_id;
            return $encryptor->decrypt($value, $context);
        }
        
        // Fallback ke metode dekripsi lama (trait Encryptable)
        return $this->decryptAttribute($value);
    }
    
    /**
     * Mendapatkan instance dari layanan enkripsi yang ditingkatkan
     * 
     * @return EnhancedEncryptionService
     */
    protected function getEnhancedEncryption()
    {
        if ($this->enhancedEncryption === null) {
            $this->enhancedEncryption = new EnhancedEncryptionService();
        }
        
        return $this->enhancedEncryption;
    }

    /**
     * Get the user that owns the payment method
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the masked card number (only showing last 4 digits)
     */
    public function getMaskedCardNumber(): string
    {
        $details = json_decode($this->encrypted_details, true);

        if (!isset($details['card_number'])) {
            return 'N/A';
        }

        $cardNumber = $details['card_number'];
        $lastFour = substr($cardNumber, -4);
        return "•••• •••• •••• " . $lastFour;
    }

    /**
     * Get the card expiry date
     */
    public function getExpiryDate(): string
    {
        $details = json_decode($this->encrypted_details, true);

        if (!isset($details['expiry_month']) || !isset($details['expiry_year'])) {
            return 'N/A';
        }

        return $details['expiry_month'] . '/' . $details['expiry_year'];
    }

    /**
     * Get formatted card type
     */
    public function getFormattedType(): string
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }
}
