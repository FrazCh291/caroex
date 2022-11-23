<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emailable extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'email_id',
        'emailable_type',
        'emailable_id',
    ];

    public function email()
    {
        return $this->belongsTo(Email::class, 'email_id', 'id');
    }
}
