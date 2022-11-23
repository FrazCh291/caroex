<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'product_id',
        'user_id',
        'order_id',
        'customer_id',
        'channel_id',
        'name',
        'email',
        'comment',
        'rating',
        'url',
        'status',
        'is_active',
        'last_sent_at',
    ];

    public function products() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function channels() {
        return $this->belongsTo(SalesChannel::class, 'channel_id', 'id');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
