<?php

namespace App\Http\Controllers;

use App\Models\Carrinho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use League\Flysystem\Config;

class ProdutosController
{
    public function index(Request $request)
    {
        $token = config('token.token');
        $currentPage = $request->input('page', 1);

        $allProducts = collect();

        //as paginas estavam vindo com poucos itens, assim traz tudo
        do {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('https://jueri.com.br/sis/api/v1/904/produto?page=' . $currentPage . '&search=' . $request->input('search'));

            $data = json_decode($response->body());

            $filteredData = collect($data->data)->filter(function ($item) {
                return $item->imagem !== null && $item->quantidade > 0 && $item->tipo_preco['0']->preco > 0;
            });

            $allProducts = $allProducts->merge($filteredData);

            $currentPage++;

        } while ($data->next_page_url);

        return view('produtos.index', compact('allProducts', 'currentPage'));
    }

    public function show($id){
        $token = config('token.token');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://jueri.com.br/sis/api/v1/904/produto/' . $id);

        $data = json_decode($response->body());

        //Verifica se ja possui a quantidade maxima do produto no carrinho
        $carrinho = Carrinho::where('produto_id', $id)->where('user_id', auth()->user()->id)->first();
        $carrinho?->quantidade >= $data->quantidade ? $available = false : $available = true;

        return view('produtos.show', compact('data', 'available'));
    }

}
