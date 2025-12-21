<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'mobile',
        'message',
        'template_id',
        'status',
        'response',
        'request_data',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'response' => 'array',
        'request_data' => 'array',
    ];

    /**
     * Scope for successful SMS
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for failed SMS
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for specific mobile number
     */
    public function scopeForMobile($query, $mobile)
    {
        return $query->where('mobile', $mobile);
    }

    /**
     * Scope for specific template
     */
    public function scopeForTemplate($query, $templateId)
    {
        return $query->where('template_id', $templateId);
    }
}
