<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model
{

    protected $table = 'real_estate';

    protected $fillable = [
        'user_id', 'title', 'description', 'content', 'price' , 'slug',
        'bedrooms', 'bathrooms', 'property_area', 'total_property_area'
    ];

    public function user(){
        
        return $this->belongsTo(User::class);
    }

    public function categories(){

        return $this->belongsToMany(Category::class, 'real_estate_categories');
    }
}
