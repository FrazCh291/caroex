<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'shipping_method',
        'sku',
        'color',
        'image',
        'price',
        'stock',
        'quantity',
        'description',
    ];
    protected $appends = [
        'last_month_count',
        'last_two_month_count',
        'last_three_month_count'
    ];

//    public function stock(): HasMany{
//        return $this->hasMany(Stock::class);
//    }

//    public function stockLog(): HasMany {
//        return $this->hasMany(StockLog::class, 'stockLog_id', 'id');
//    }

//    public function stockLog(): BelongsTo
//    {
//        return $this->belongsTo(StockLog::class, 'stockLog_id', 'id');
//    }

    public function warehouseStocks()
    {
        return $this->hasMany(WarehouseStock::class, 'product_id', 'id');
    }

    public function prodcutStock()
    {
        return $this->hasOne(ProductStock::class, 'product_id', 'id')->latest('date');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


//    public function stockLog()
//    {
//        return $this->hasMany(StockLog::class);
//    }

    public function order()
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }

    public function productitle()
    {
        return $this->hasMany(ProductTitle::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    public function getLastMonthCountAttribute()
    {
        $date = Carbon::now();
        $lastMonth =  $date->subMonth();
         return $this->order()->where('order_date', '>=', $lastMonth)->count();
    }

    public function getLastTwoMonthCountAttribute()
    {
        $date = Carbon::now();
        $lastTwoMonth =  $date->subMonth(2);
        return $this->order()->where('order_date', '>=', $lastTwoMonth)->count();
    }
    public function productType()
    {
        return $this->belongsTo(Lookup::class ,'product_type','slug');
    }

    public function getLastThreeMonthCountAttribute()
    {
        $date = Carbon::now();
        $lastThreeMonth =  $date->subMonth(3);
        return $this->order()->where('order_date', '>=', $lastThreeMonth)->count();
    }

    public function getSkuAttribute($value)
    {
        return strtoupper($value);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

}
