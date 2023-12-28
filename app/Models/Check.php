<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Check extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
      'order_id'
    ];

    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class);
    }
}
