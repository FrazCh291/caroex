<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentToken extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function paymentTokenMeta()
    {
        return $this->hasMany('paymentTokenMeta');
    }
}
