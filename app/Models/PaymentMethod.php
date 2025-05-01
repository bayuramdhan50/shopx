<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
