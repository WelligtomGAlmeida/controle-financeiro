<?php

namespace App\Http\Controllers;

use App\Person;
use App\Transaction;
use Exception;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $cpf;

    public function setCpf($cpf){
        $this->cpf = $cpf;
    }

    public function getCpf($cpf){
        return $this->cpf;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function extrato($cpf)
    {
        return response()->json([
            'retorno' => 'Função não implementada!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saldo($cpf)
    {
        return response()->json([
            'retorno' => 'Função não implementada!'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function credito(Request $request)
    {

        //Regras de validação
        $rules = [
            'cpf' => 'required|min:11|max:11|exists:people,cpf',
            'valor' => 'required|numeric|between:0,9999999999.99'
        ];

        // Mensagens de validação
        $messages = [
            'cpf.required' => 'O CPF deve ser informado!',
            'cpf.min' => 'O CPF deve ter 11 caracteres!',
            'cpf.max' => 'O CPF deve ter 11 caracteres!',
            'cpf.exists' => 'Este CPF não está cadastrado!',
            'valor.required' => 'O valor deve ser informado!',
            'valor.numeric' => 'O valor deve ser do tipo decimal!',
            'valor.between' => 'O valor deve ser maior que 0 e menor que 9999999999.99!',
        ];

        // Validando os dados fornecidos
        $request->validate($rules, $messages);

        // Buscando a pessoa no banco de dados
        $person = Person::where('cpf', $request->cpf)->first();

        // Instanciando uma transação com os dados fornecidos
        $transaction = new Transaction([
            'person_id' => $person->id,
            'transaction_type_id' => 1,
            'transaction_movement_id' => 1,
            'value' => $request->valor
        ]);

        try{
            // Registrando a transação no banco
            $transaction->save();
        }catch(Exception $e){
            // Retorno caso houver erro
            return response()->json([
                'message' => 'Houve um erro ao aplicar o crédito!'
            ], 500);
        }

        // Retorno caso houver sucesso
        return response()->json([
            'message' => 'Crédito aplicado com sucesso!',
            'data' => [
                'cpf' => $person->cpf,
                'valor' => $transaction->value
            ],
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function debito(Request $request)
    {
        $this->setCpf($request->cpf);

        //Regras de validação
        $rules = [
            'cpf' => ['required', 'min:11', 'max:11', 'exists:people,cpf'],
            'valor' => ['required', 'numeric', 'between:0,9999999999.99', function($attribute, $value, $fail){
                if($this->calcularSaldo() != null && $this->calcularSaldo() - $value < 0){
                    return $fail("Saldo insuficiente! O valor do débito é maior que o saldo atual.");
                }
            }]
        ];

        // Mensagens de validação
        $messages = [
            'cpf.required' => 'O CPF deve ser informado!',
            'cpf.min' => 'O CPF deve ter 11 caracteres!',
            'cpf.max' => 'O CPF deve ter 11 caracteres!',
            'cpf.exists' => 'Este CPF não está cadastrado!',
            'valor.required' => 'O valor deve ser informado!',
            'valor.numeric' => 'O valor deve ser do tipo decimal!',
            'valor.between' => 'O valor deve ser maior que 0 e menor que 9999999999.99!',
        ];

        // Validando os dados fornecidos
        $request->validate($rules, $messages);

        // Buscando a pessoa no banco de dados
        $person = Person::where('cpf', $request->cpf)->first();

        // Instanciando uma transação com os dados fornecidos
        $transaction = new Transaction([
            'person_id' => $person->id,
            'transaction_type_id' => 2,
            'transaction_movement_id' => 2,
            'value' => $request->valor
        ]);

        try{
            // Registrando a transação no banco
            $transaction->save();
        }catch(Exception $e){
            // Retorno caso houver erro
            return response()->json([
                'message' => 'Houve um erro ao aplicar o débito!'
            ], 500);
        }

        // Retorno caso houver sucesso
        return response()->json([
            'message' => 'Débito aplicado com sucesso!',
            'data' => [
                'cpf' => $person->cpf,
                'valor' => $transaction->value
            ],
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transferencia(Request $request)
    {
        return response()->json([
            'retorno' => 'Função não implementada!'
        ]);
    }

    /**
     * Função que calcula o saldo de uma pessoa
     */
    public function calcularSaldo(){
        // Buscando a pessoa
        $person = Person::where('cpf', $this->cpf)->first();

        if($person){
            // Calculando os crédito e débitos da pessoa informada
            $transactions = Transaction::where('person_id',$person->id)
                        ->groupBy('transaction_movement_id')
                        ->selectRaw('sum(value) as total, transaction_movement_id')
                        ->pluck('total','transaction_movement_id');

            // Trantando os valores de crédito e débito que vem do banco
            $creditos = isset($transactions[1]) ? floatval($transactions[1]) : 0;
            $debitos = isset($transactions[2]) ? floatval($transactions[2]) : 0;

            // Calculando o saldo
            $saldo = $creditos - $debitos;

        }else{
            $saldo = null;
        }
        return $saldo;
    }
}
