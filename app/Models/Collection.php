<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable =[
        'customer_id',
        'company_id',
        'request_type',
        'case_id',
        'tracking_number',
        
    ];

    protected $appends = ['start','end','title'];

    public function getTitleAttribute()
    {
        return 'Collection ('.$this->return_status.')';
    }

    public function getStartAttribute()
    {
        return $this->return_at;
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function getEndAttribute()
    {
        return $this->return_at;
    }

    public function setEndAttribute($value)
    {
        $this->attributes['start'] = $value;
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
