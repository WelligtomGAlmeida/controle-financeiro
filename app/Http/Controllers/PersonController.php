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
            'cpf.required' => 'The CPF is required!',
            'cpf.min' => 'The CPF must be 11 characters long!',
            'cpf.max' => 'The CPF must be 11 characters long!',
            'cpf.unique' => 'The CPF is already registered!',
            'name.max' => 'The name must be a maximum of 100 characters',
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
                'status' => 2,
                'message' => 'An error occurred while registering the person!',
                'errors' => [$e]
            ], 500);
        }

        // Retorno caso houver sucesso
        return response()->json([
            'status' => 1,
            'message' => 'Person successfully registered!',
            'data' => [
                'person' => $person
            ],
        ], 201);
    }
}
