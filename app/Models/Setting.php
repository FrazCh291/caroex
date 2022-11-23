<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Setting extends Model
{
    use Notifiable;
    use SoftDeletes;
    use HasFactory;

    public function routeNotificationForMail()
    {
        return $this->slug;
    }
}
