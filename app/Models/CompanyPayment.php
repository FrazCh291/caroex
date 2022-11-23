<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Company::class, 'supplier_id', 'id');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(Lookup::class, 'payment_method', 'slug');
    }

    public function payeeAccount()
    {
        return $this->belongsTo(accounts::class, 'payee_account_id', 'id');
    }
    public function payerAccount()
    {
        return $this->belongsTo(accounts::class, 'payer_account_id', 'id');
    }
    public function documents()
    {
        return $this->morphMany(Documents::class, 'documentable');
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
