<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory;
    use SoftDeletes;
 
  protected $fillable = [
    'id',
    'company_id',
    'name',
    'code',
    'phone',
    'address_1',
    'address_2',
    'city',
    'state',
    'country',
    'zip_code',
    'length',
    'width',
    'height',
    'volume',
    'is_occupied',
    'deleted_at',
    'created_at',
    'updated_at'
  ];


    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
