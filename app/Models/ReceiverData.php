<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiverData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receiver_id',
        'phone_number',
        'ssn',
        'birth_date',
        'address',
        'address_2',
        'postal_code',
        'city',
        'state',
        'country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'receiver_id',
        'created_at',
        'updated_at',
    ];

    /**
     * The owner receiver of the data
     */
    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }
}
