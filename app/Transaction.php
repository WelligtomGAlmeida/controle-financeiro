<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'person_id',
        'transaction_type_id',
        'transaction_movement_id',
        'value'
    ];

    /**
     * Função responsável pelo relacionamento entre uma transação e a pessoa envolvida
     */
    public function person(){
        return $this->belongsTo('App\Person');
    }

    /**
     * Função responsável pelo relacionamento entre uma transação e o seu Tipo
     */
    public function transactionType(){
        return $this->belongsTo('App\TransactionType');
    }

    /**
     * Função responsável pelo relacionamento entre uma transação e o seu movimento(Crédito ou débito)
     */
    public function transactionMovement(){
        return $this->belongsTo('App\TransactionMovement');
    }
}
