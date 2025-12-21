<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'category_id',
        'condition_id',
        'name',
        'brand_name',
        'price',
        'description',
        'seller_id',
        'buyer_id',
        'status',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function likedByUsers(){
        return $this->belongsToMany(User::class,'likes','item_id','user_id')->withTimestamps();
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function seller(){
        return $this->belongsTo(User::class,'seller_id');
    }

    public function buyer(){
        return $this->belongsTo(User::class,'buyer_id');
    }

    public function isSold(){
        return !is_null($this->buyer_id);
    }

    public function oders(){
        return $this->hasMany(Oder::class);
    }

    public function sold(){
        return SoldItem::where('item_id',$this->id)->exists();
    }
}
