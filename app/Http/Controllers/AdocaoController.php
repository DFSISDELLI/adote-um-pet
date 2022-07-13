<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adocao;
use App\Http\Resources\AdocaoCollection;
use  App\Rules\AdocaoUnicaPet;

class AdocaoController extends Controller
{
    public function index()
    {
        $adocoes =  Adocao::with('pet')->get();

        return new AdocaoCollection($adocoes);
    }

    /**
     * Cria um novo registro de adocao
     * 
     * @param Request $request
     * @return  Adocao
     * 
     */

    public function store(Request $request)
    {
        $request->validate([
            "email" => ['required', 'email', new AdocaoUnicaPet($request->input('pet_id', 0))],
            "valor" => ['required', 'numeric', 'between:5,100'],
            "pet_id" => [ 'required', 'int', 'exists:pets,id']

        ]);

        $dadosDaAdocao = $request->all();

        return Adocao::create($dadosDaAdocao);
    }
}
