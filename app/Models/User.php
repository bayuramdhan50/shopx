<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Encryptable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_admin',
        'password',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'payment_info',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'payment_info',
    ];

    /**
     * Define which attributes should be encrypted
     *
     * @var array<string>
     */
    protected $encryptable = [
        'phone',
        'address',
        'payment_info',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the user's cart items
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
    
    /**
     * Get the user's payment methods
     */
    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }
    
    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saved(function ($user) {
            Log::info('User saved successfully', [
                'id' => $user->id,
                'name' => $user->name,
                'updated_fields' => $user->getDirty()
            ]);
        });
        
        static::updated(function ($user) {
            Log::info('User updated successfully', [
                'id' => $user->id,
                'updated_fields' => array_keys($user->getDirty())
            ]);
        });
    }
}
