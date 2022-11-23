<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseSparePartItems extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function sparePart()
    {
        return $this->belongsTo(Product::class, 'sparepart_id','id');
    }
    public function statuss()
    {
        return $this->belongsTo(Lookup::class, 'status','slug');
    }
    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id','id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
