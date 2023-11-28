<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    protected $fillable = [
        'uuid', // add uuid attribute to fillable property
        'owner_id',
        'sender_id',
        'template_id',
        'subject',
        'to',
        'cc',
        'bcc',
        'body',
        'sender_name',
        'mail_status',
        'email',
        'company_id',
        'message'
    ];
    use HasFactory;
}
