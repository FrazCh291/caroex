<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class paymentTokenMeta extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function paymentToken()
    {
        return $this->belongsTo('paymentToken');
    }
}
