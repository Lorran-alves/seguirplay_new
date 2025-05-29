<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'email',
        'profile',
        'price',
        'price_tot',
        'price_sale',
        'quantity',
        'status',
        'pending',
        'termos_id',
        'politicas_id',
        'payment_id',
        'payment_method',
        'period',
        'log',
        'purchase_pai_id',
        'type_purchase',
    ];
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function planActive()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id')->where('isActive', '1');
    }

    public function convertPrice(): Attribute
    {
        return new Attribute(
            get: fn() => number_format($this->price, 2, ',', '.'),
        );
    }

    public function whatsappLink(): Attribute
    {
        return new Attribute(
            get: fn () => 'https://api.whatsapp.com/send?phone=55' . $this->clearField($this->phone),
        );
    }

    private function clearField($value)
    {
        return preg_replace("/[^0-9]/", "", $value);
    }

    public function scopeApproved($query)
    {
        $query->where('status', 'success');
        $query->orwhere('status', 'send');
    }
}
