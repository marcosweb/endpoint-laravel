<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'cnpj',
        'razao_social'
    ];

    public function vendedores()
    {
        return $this->hasMany('App\Vendedor', 'empresa', 'id');
    }
}
