<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Gogroopie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'deal_id',
        'company_id',
        'import_id',
        'product_id',
        'voucher_code',
        'full_name',
        'email',
        'house',
        'street',
        'city',
        'postcode',
        'country',
        'phone',
        'redeem_date',
        'price_option',
        'deal_option',
        'product',
        'sku',
    ];

    public function import()
    {
        return $this->belongsTo(Import::class, 'import_id', 'id');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
