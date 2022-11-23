<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
            'first_name',
            'last_name',
            'email',
            'phone',
            'company',
            'industry',
            'message',
            'industry',
    
    ];
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
