<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'bookings';

    protected $fillable = [
        'booking_code',
        'property_id',
        'user_id',
        'check_in_date',
        'check_out_date',
        'total_nights',
        'guests_count',
        'price_per_night',
        'cleaning_fee',
        'service_fee',
        'total_price',
        'pricing_breakdown',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'total_nights' => 'integer',
        'guests_count' => 'integer',
        'price_per_night' => 'float',
        'cleaning_fee' => 'float',
        'service_fee' => 'float',
        'total_price' => 'float',
        'pricing_breakdown' => 'array',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
