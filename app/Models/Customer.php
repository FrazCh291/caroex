<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;


    protected $fillable = [
        'name',
        'company_id',
        'channel_id',
        'import_id',
        'email',
        'address1_2',
        'house_number',
        'phone',
        'city',
        'postcode',
        'country',
    ];


    public function channel()
    {
        return $this->belongsTo(SalesChannel::class, 'channel_id', 'id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
    public function case()
    {
        return $this->hasMany(Cases::class);
    }
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }
    public function email()
    {
        return $this->hasMany(Email::class, 'case_id' , 'id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id'  , 'id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
    public function import()
    {
        return $this->belongsTo(Import::class, 'import_id' ,'id');
    }
    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }
}
