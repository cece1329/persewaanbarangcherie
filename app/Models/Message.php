<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'auto_reply_sent',
        'is_read',
        'admin_reply',
        'replied_at',
    ];

    protected $casts = [
        'auto_reply_sent' => 'boolean',
        'is_read' => 'boolean',
        'replied_at' => 'datetime',
    ];
}
