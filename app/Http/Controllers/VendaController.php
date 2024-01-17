<?php

namespace App\Http\Controllers;

use App\Models\carrinho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VendaController extends Controller
{
    public function venda(Request $request){
        try {
            $user = auth()->user();

            $produtos = $user->carrinho;

            $produtos = $produtos->map(function ($produto) {
                return [
                    'produto' => [
                        'codigo_barras' => $produto->codigo_barras,
                    ],
                    'quantidade' => $produto->quantidade,
                    'valor_unitario' => $produto->preco,
                    'fk_tipo_preco_id' => 1,
                ];
            });

            $preco_total = $request->input('preco_total');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('token.token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://jueri.com.br/sis/api/v1/904/venda', [
                'comprador' => [
                    'tipo' => 'cliente',
                    'nome' => $user->name,
                    'cpf_cnpj' => $request->input('cpf'),
                    'email' => $user->email
                ],
                'itens' => $produtos,
                'forma_pagamento' => [
                    'desconto' => 0,
                    'acrescimo' => 0,
                    'boleto' => [
                        [
                            'valor' => $preco_total,
                            'data_vencimento' => '2023-01-01',
                            'numero_boleto' => 1,
                        ],
                    ],
                ],
            ]);

            $this->limparCarrinho();
            return redirect()->route('home')->with('message', 'Compra realizada com sucesso!');
        }
        catch (\Throwable $th){
            return redirect()->route('carrinho.index')->withErrors('Erro ao realizar compra!');
        }
    }

    public function limparCarrinho(){
        foreach(auth()->user()->carrinho as $produto) {
            $produto->delete();
        }
    }
}

