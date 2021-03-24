<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiosPortateis extends Model
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
        'regiao',
        'responsavel',
        'instalacao',
        'imagem'
    ];
}
