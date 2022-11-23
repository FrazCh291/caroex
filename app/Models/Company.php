<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $softDelete = true;
    protected $with = [
        'companyOwner'
    ];

    protected $fillable = [
        'name',
        'type',
        'parent_id'
    ];

    public function permissions()
    {
        return $this->modules->pluck('permissions')->collapse();
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modules()
    {
        return $this->belongsToMany(Module::class, 'company_modules');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function companyOwner()
    {
        return $this->hasOne(User::class, 'company_id')->where('is_owner', true);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'company_id')->where('is_owner', false);
    }

//    public function activeSubscription()
//    {
//        return $this->belongsTo(Subscription::class, 'id', 'company_id')->where('is_active', true);
//    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'id', 'company_id')->where('is_active', true);

    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function beneficiary()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function intermediary()
    {
        return $this->hasMany(Intermediary::class);
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
