<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 200;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * The model's table attributes
     * 
     * @var array
     */
    private $tableAttributes = [
        'id',
        'name',
        'status'
    ];

    /**
     * The Accessor for the 'status' attribute
     */
    public function getStatusAttribute($value)
    {
        if ($value === self::STATUS_ACTIVE) {
            return __('Active');
        } else if ($value === self::STATUS_INACTIVE) {
            return __('Inactive');
        } else {
            return __('Undefined');
        }
    }

    /**
     * Get attribute names
     */
    public function getAttributeNamesForTable()
    {
        // $attributeNames = array_keys($this->getAttributes());
        
        // $visibleAttributes = array_values( array_diff($attributeNames, $this->hidden) );

        // return array_map('ucfirst', preg_replace('#[_]+#', ' ', $visibleAttributes));
        return array_map('ucfirst', preg_replace('#[_]+#', ' ', $this->tableAttributes));
    }

    /**
     * Extract necessary object attributes for the tables
     */
    public function getAttributesForTable()
    {
        $attributes = [];
        foreach ($this->attributesToArray() as $key => $value) {
            if (in_array($key, $this->tableAttributes)) {
                $attributes[$key] = $value;
            }
        }
        return $attributes;
    }

    /**
     * Set the status of a saved model
     * @warning It mustn't be 'setStatusAttribute' 'cause Laravel will process it through the core
     * in that case
     */
    public static function setStatus($value)
    {
        if ($value === 'Active' || $value === true) {
            return self::STATUS_ACTIVE;
        } else if ($value === 'Inactive' || $value === false) {
            return self::STATUS_INACTIVE;
        }
    }

    /**
     * All statuses are presented in the array
     */
    public static function getClientStatuses()
    {
        return ['Active', 'Inactive', 'Undefined', true, false];
    }
}
