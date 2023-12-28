<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'titel',
        'price',
        'inventory',
        'sold_number',
        'description',
    ];
    public function orders(){
        return $this->belongsToMany(Order::class)->withpivot('count');
    }
    use SoftDeletes;
}
