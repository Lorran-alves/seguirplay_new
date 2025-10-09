<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupomUnico extends Model
{
    use HasFactory;

    protected $table = "cupons_unicos";

    protected $fillable = [
        'nome',
        'desconto',
        'validade'
    ];
}


?>