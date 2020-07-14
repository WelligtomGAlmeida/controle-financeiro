<?php

namespace App\Http\Controllers;

use App\Person;
use Exception;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Registra uma pessoa no banco
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Regras de validação
        $rules = [
            'cpf' => 'required|min:11|max:11|unique:people',
            'name' => 'max:100'
        ];

        // Mensagens de retorno
        $messages = [
            'cpf.required' => 'É obrigatório o preenchimento do CPF!',
            'cpf.min' => 'O CPF deve ter 11 caracteres!',
            'cpf.max' => 'O CPF deve ter 11 caracteres!',
            'cpf.unique' => 'Este CPF já está cadastrado!',
            'name.max' => 'O nome deve ter no máximo 100 caracteres',
        ];

        // Validando os dados fornecidos
        $request->validate($rules, $messages);

        // Instanciando uma pessoa com os dados fornecidos
        $person = new Person([
            'cpf' => $request->cpf,
            'name' => $request->name,
        ]);

        try{
            // Registrando a pessoa no banco
            $person->save();
        }catch(Exception $e){
            // Retorno caso houver erro
            return response()->json([
                'retorno' => 'Houve um erro ao cadastrar esta pessoa!'
            ], 500);
        }

        // Retorno caso houver sucesso
        return response()->json([
            'retorno' => 'Pessoa cadastrada com sucesso!',
            'pessoa' => $person
        ], 201);
    }
}