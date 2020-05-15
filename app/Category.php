<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'description', 'slug'
    ];

    public function realEstates(){

        return $this->belongsToMany(RealEstate::class, 'real_estate_categories');
    }
}
