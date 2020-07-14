<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $filable = [
        'name'
    ];

    /**
     * Função responsável pelo relacionamento entre Tipos de transação e suas respectivas transações
     */
    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
