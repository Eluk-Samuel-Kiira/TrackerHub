<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
    protected $fillable = [
        'app_name',
        'app_email',
        'app_contact',
        'meta_keyword',
        'meta_descrip',
        'favicon',
        'logo',
        'mail_status',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_address',
        'mail_name',
    ];
}
