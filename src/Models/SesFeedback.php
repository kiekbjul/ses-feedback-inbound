<?php

namespace Kiekbjul\SesFeedbackInbound\Models;

use Illuminate\Database\Eloquent\Model;

class SesFeedback extends Model
{
    protected $fillable = [
        'ses_message_id', 'type', 'full_message',
    ];

    protected $casts = [
        'full_message' => 'array',
    ];

    public function message()
    {
        return $this->belongsTo(SesSentMessage::class);
    }

    public function getMailAttribute()
    {
        return $this->full_message['mail'];
    }

    public function getDataAttribute()
    {
        return $this->full_message[$this->type];
    }
}
