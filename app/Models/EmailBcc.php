<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailBcc extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_id',
        'name',
        'address'
    ];
    protected $table = 'email_bccs';
}
