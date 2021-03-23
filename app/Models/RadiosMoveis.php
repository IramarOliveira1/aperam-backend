<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiosMoveis extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patrimonio',
        'radio_modelo',
        'numero_serie',
        'veiculo_modelo',
        'placa',
        'regiao',
        'responsavel',
        'departamento',
    ];
}
