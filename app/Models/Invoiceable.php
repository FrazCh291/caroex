<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoiceable extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'saas_id',
        'invoice_id',
        'invoiceable_type',
        'invoiceable_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
