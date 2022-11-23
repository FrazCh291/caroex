<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Module extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    protected $with =[
        'permissions'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_modules');
    }

    public function packages()
    {
        return $this->belongsToMany(Package::class,'module_package');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
