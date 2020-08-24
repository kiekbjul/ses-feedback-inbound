<?php

namespace Kiekbjul\SesFeedbackInbound\Models;

use Illuminate\Database\Eloquent\Model;

class SesInbound extends Model
{
    protected $fillable = [
        'ses_message_id', 'full_message',
    ];

    protected $casts = [
        'full_message' => 'array',
    ];

    public function getMailAttribute()
    {
        return $this->full_message['mail'];
    }

    public function getReceiptAttribute()
    {
        return $this->full_message['receipt'];
    }
}
