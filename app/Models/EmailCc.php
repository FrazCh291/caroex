<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCc extends Model
{
    protected $fillable = [
        'email_id',
        'name',
        'address'
    ];
    protected $table = 'emails_cc';

    public function emailable()
    {
        return $this->morphMany(Emailable::class, 'emailable');
    }
}
