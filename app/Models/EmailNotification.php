<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailNotification extends Model
{
    
    use HasFactory;

    protected $table = "email_notifications";

    protected $fillable = [
        'email',
        'last_purchase_date',
        'send_1_week',
        'send_3_month',
        'accept_email',
        'tot_emails_send',
    ];
}
