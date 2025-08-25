<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_condition',
        'name',
        'brand_name',
        'price',
        'sellder_id',
        'buyer_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function likes(){
        return $this->belongsToMany(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
