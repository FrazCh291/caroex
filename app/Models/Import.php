<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Import extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with = ['channel'];
    protected $fillable = [
        'channel_id',
        'company_id',
        'file_name',
        'file_size',
        'number_of_rows',
        'user_id'
    ];

    public function channel()
    {
        return $this->belongsTo(SalesChannel::class, 'channel_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function amazon()
    {
        return $this->hasMany(Amazon::class);
    }

    public function ejogga()
    {
        return $this->hasMany(Ejogga::class);
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }

}
