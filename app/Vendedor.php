<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    protected $fillable = [
        'nome',
        'idade',
        'empresa'
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'id', 'empresa');
    }
}
