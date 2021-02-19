<?php

namespace ACME\Zepo\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'support_tickets';

	protected $fillable = [
        'name',
        'email',
        'message',
        'attachment',
        'status',
    ];
}
