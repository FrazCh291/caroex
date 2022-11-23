<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseStock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
        'company_id',
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function wareHouse(): BelongsTo {
        return $this->belongsTo(Company::class,'warehouse_id','id');
    }

    public function stockItem(): HasMany {
        return $this->hasMany(StockLog::class);
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
