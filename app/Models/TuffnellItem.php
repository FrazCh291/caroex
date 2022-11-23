<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TuffnellItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'order_item_id',
        'tuffnell_id',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
