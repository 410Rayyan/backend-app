<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Property extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'properties';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'host_id',
        'city',
        'country',
        'address',
        'price_per_night',
        'max_guests',
        'bedrooms',
        'bathrooms',
        'amenities',
        'images',
        'status',
        'featured',
    ];

    protected $casts = [
        'price_per_night' => 'float',
        'max_guests' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'amenities' => 'array',
        'images' => 'array',
        'featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'property_id');
    }
}
