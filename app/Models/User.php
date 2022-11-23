<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_super',
        'company_id',
        'is_erp',
        'is_fulfilment',
        'is_admin',
        'is_owner',
    ];
    protected $primaryKey="id";
    protected $with = [
        'subscription',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($permission)
    {

        return $this->role->permissions()->where('action', $permission)->first();
    }

    public function permissions()
    {
        return $this->is_super ? Permission::all()->pluck('action') : ($this->role ? $this->role->permissions->pluck('action') : []);
    }

    public function isMemberOf(Company $company)
    {
        return $this->role->company_id == $company->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class)->where('is_active', true);

    }

    public function paymentToken()
    {
        return $this->hasMany('paymentToken');
    }

    public function reviews(): HasMany {
        return $this->hasMany(Review::class);
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
