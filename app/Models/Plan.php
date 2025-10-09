<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'provedor',
        'id_provedor',
        'price',
        'quantity',
        'quantity_min',
        'type'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function convertPrice(): Attribute
    {
        if(empty($this->quantity_min)){
            return new Attribute(
                get: fn() => number_format($this->price, 2, ',', '.'),
            );
        }else{
            return new Attribute(
                get: fn() => number_format($this->price * ($this->quantity_min ?? $this->quantity), 2, ',', '.'),
            );
        }
    }
    public function price(): Attribute
    {
        return new Attribute(
            set: fn($value) => $this->convertStringDouble($value),
        );
    }
    private function convertStringDouble($param)
    {
        if (empty($param)) {
            return null;
        }

        return str_replace(',', '.', str_replace('.', '', $param));
    }
}
