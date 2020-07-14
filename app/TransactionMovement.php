<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionMovement extends Model
{
    protected $filable = [
        'name'
    ];

    /**
     * Função responsável pelo relacionamento entre movimentos de transações(Crédito ou Débito)
     * e suas respectivas transações
     */
    public function transactions(){
        return $this->hasMany('App\Transaction');
    }
}
