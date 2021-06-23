<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS_PENDING = 1;
    const STATUS_APPROVED = 200;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'device_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'device_name',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_PENDING,
    ];

    /**
     * The Accessor for the 'status' attribute
     */
    public function getStatusAttribute($value)
    {
        if ($value === self::STATUS_APPROVED) {
            return __('Active');
        } else if ($value === self::STATUS_PENDING) {
            return __('Pending');
        } else {
            return __('Undefined');
        }
    }

    /**
     * Get attribute names
     */
    public function getAttributeNames()
    {
        $attributeNames = array_keys($this->getAttributes());
        
        $visibleAttributes = array_values( array_diff($attributeNames, $this->hidden) );

        return array_map('ucfirst', preg_replace('#[_]+#', ' ', $visibleAttributes));
    }

    /**
     * All statuses are presented in the array
     */
    public static function getClientStatuses()
    {
        return ['Active', 'Pending', 'Undefined', true, false];
    }
}
