<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'attachment_id',
        'channel_id',
        'case_id',
        'parent_id',
        'email_id',
        'draft_email_parent_id',
        'subject',
        'body',
        'from_email',
        'from_name',
        'to_email',
        'to_name',
        'marked_as_read',
        'email_account_id',
        'folder',
        'previous_folder',
        'is_stared',
        'date',
    ];
    protected $appends = ['fromm'];

    public function getFrommAttribute()
    {
        return $this->from_email;
    }

    public function getBodyAttribute($value)
    {
        return html_entity_decode($value);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'email_id', 'email_id')->where('is_inline', 0);
    }

    public function inlineAttachments()
    {
        return $this->hasMany(Attachment::class, 'email_id', 'email_id')->where('is_inline', 1);
    }

    public function childEmails()
    {
        return $this->hasMany(Email::class, 'parent_id', 'id');
    }

    public function emailSetting()
    {
        return $this->belongsTo(EmailSetting::class, 'to_email', 'username');
    }

    public function ccEmails()
    {
        return $this->hasMany(EmailCc::class, 'email_id', 'id');
    }

    public function childCcEmails()
    {
        return $this->hasMany(EmailCc::class, 'email_id', 'email_id');
    }

    public function chennel()
    {
        return $this->belongsTo(SalesChannel::class, 'channel_id', 'id');
    }

    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id', 'id');
    }

    public function logs()
    {
        return $this->morphMany(ActivityLog::class, 'logable');

    }

    public function emailAccount()
    {
        return $this->belongsTo(EmailAccount::class, 'email_account_id', 'id');
    }

    public function emailable()
    {
        return $this->morphTo();
    }

    public function emailCcs()
    {
        return $this->morphedByMany(EmailCc::class, 'emailable');
    }
}
