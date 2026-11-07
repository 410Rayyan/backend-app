<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'category_id');
    }
}
