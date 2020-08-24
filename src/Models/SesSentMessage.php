<?php

namespace Kiekbjul\SesFeedbackInbound\Models;

use Illuminate\Database\Eloquent\Model;

class SesSentMessage extends Model
{
    protected $fillable = [
        'ses_message_id', 'full_message',
    ];

    protected $casts = [
        'full_message' => 'array',
    ];

    public function feedback()
    {
        return $this->hasMany(SesFeedback::class, 'ses_message_id', 'ses_message_id');
    }
}
