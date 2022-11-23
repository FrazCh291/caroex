<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseContainer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded= [];

    protected $fillable =[
        'company_id',
        'container_no',
        'container_ordered_at',
        'deleted_at',
        
    ];

    protected $appends = ['start','end','title'];

    public function getTitleAttribute()
    {
        return 'Container ('.$this->container_no.')';
    }

    public function getStartAttribute()
    {
        return $this->container_ordered_at;
    }
    
    public function setStartAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function getEndAttribute()
    {
        return $this->container_ordered_at;
    }

    public function setEndAttribute($value)
    {
        $this->attributes['start'] = $value;
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function warehouseContainerContext()
    {
        return $this->hasMany(WarehouseContainerContext::class);
    }
    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
