<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wowcher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'import_id',
        'deal_id',
        'product_id',
        'redeemed_at',
        'wowcher_code',
        'deal_title',
        'customer_name',
        'house_number',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_address_town',
        'shipping_county',
        'shipping_country_code',
        'shipping_address_postcode',
        'address_line_1',
        'address_line_2',
        'city',
        'country',
        'postcode',
        'email',
        'phone',
        'birthday',
        'marketing_permission',
        'product_name',
        'product_options',
        'sku',
        'despatch_method',
        'import_id',
    ];


    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
