<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'status',
        'charge',
        'purchase_id',
        'period',
    ];
    public $timestamps = false;
    
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function convertPrice(): Attribute
    {
        return new Attribute(
            get: fn() => number_format($this->price, 2, ',', '.'),
        );
    }

    private function clearField($value)
    {
        return preg_replace("/[^0-9]/", "", $value);
    }

    public function scopeApproved($query)
    {
        $query->where('status', 'approved');
    }
}