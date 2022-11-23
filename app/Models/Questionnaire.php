<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'Label',
        'value',
        'type',
        'description',
        'is_enable'
    ];

    public function quotation_requests()
     {
        return $this->hasMany(QuotationRequest::class);
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
