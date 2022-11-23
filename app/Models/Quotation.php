<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id', 'id');
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id', 'id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
