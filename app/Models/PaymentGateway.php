<?php

namespace App\Models;

use FontLib\Table\Type\name;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentGateway extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'private_key',
        'secret_key',
    ];
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
