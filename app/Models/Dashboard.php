<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    protected $table = 'dashboard';

    protected $fillable = [
        'period',
        'total_sales',
        'total_expenses',
        'new_customers',
        'new_customers_purchases',
        'old_customers',
        'old_customers_purchases',
        'total_customer_purchases',
    ];
}
