<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $filable = [
        'cpf',
        'name'
    ];

    /**
     * Função responsável pelo relacionamento entre Pessoas e suas respectivas transações
     */
    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
