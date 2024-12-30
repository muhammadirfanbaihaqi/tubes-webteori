<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'is_active',
        // 'is_sale',
    
    ];

    //
    protected $casts = [
        'images' => 'array',
    ];

    public function category() {
        return $this->belongsTo((Category::class));
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);  // hasMany relation with OrderItem model
    }
}
