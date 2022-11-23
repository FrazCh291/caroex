<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'payments';
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'company_id',
        'package_id',
        'correlation_id',
        'ack',
        'version',
        'build',
        'amt',
        'currency_code',
        'avs_code',
        'cvv2_match',
        'transaction_id',
        'card_crypt',
        'timestamp',
        'created_at'
    ];

    protected $hidden = [

        'updated_at'
    ];
    /**
     * @var mixed
     */
    private $company_id;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');
    }
}
