<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailSetting extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [];

   public function channel()
   {
       return $this->belongsTo(SalesChannel::class, 'channel_id', 'id');
   }

    public function emailAccount()
    {
        return $this->belongsTo(EmailAccount::class, 'email_account_id', 'id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
