<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mockery\Matcher\Not;

class Cases extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function lookup()
    {
        return $this->belongsTo(Lookup::class, 'priority_id', 'id');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
    public function casetype()
    {
        return $this->belongsTo(Lookup::class, 'type', 'id');
    }

    public function channel()
    {
        return $this->belongsTo(SalesChannel::class, 'channel_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function collection()
    {
        return $this->hasMany(Returns::class, 'case_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function caseItem()
    {
        return $this->hasMany(CaseItem::class, 'case_id', 'id');
    }

    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }

    public function notes()
    {
        return $this->morphMany(Notes::class, 'notesable');
    }

    public function emails()
    {
        return $this->hasMany(Email::class, 'case_id', 'id');
    }

    public function childEmails()
    {
        return $this->hasMany(Email::class, 'case_id', 'id');
    }
    public function caseTask()
    {
        return $this->hasMany(CaseTask::class, 'case_id','id');
    }
    public function caseSparePartItem()
    {
        return $this->hasMany(CaseSparePartItems::class, 'case_id','id');
    }
}
