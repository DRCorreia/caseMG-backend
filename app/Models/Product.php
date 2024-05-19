<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        "user_id",
        "name",
        "description",
        "image",
        "value"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function movement(){
        return $this->hasMany(Movement::class);
    }

    public function stock(){
        return $this->hasOne(Stock::class);
    }
}
