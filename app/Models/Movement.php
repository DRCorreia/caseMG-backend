<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;
    protected $table = 'movements';

    protected $fillable = [
        "product_id",
        "movement_type",
        "movement_qty",
    ];

    public function products(){
        return $this->belongsTo(Product::class);
    }
}
