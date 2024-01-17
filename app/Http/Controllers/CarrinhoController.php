<?php

namespace App\Http\Controllers;

use App\Models\carrinho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CarrinhoController extends Controller
{

    public function index()
    {
        $carrinho = auth()->user()->carrinho;

        $precoTotal = 0;
        foreach($carrinho as $item){
            $precoTotal += $item->preco * $item->quantidade;
        }

        return view('carrinho.index', compact('carrinho', 'precoTotal'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if(auth()->user()->carrinho->contains('produto_id', $request->input('produto_id'))){
                $carrinho = auth()->user()->carrinho->where('produto_id', $request->input('produto_id'))->first();
                $carrinho->quantidade += 1;
                $carrinho->save();
                DB::commit();
                return redirect()->back()->with('message', 'Item adicionado ao carrinho!');
            }

            $carrinho = Carrinho::create([
                'user_id' => auth()->user()->id,
                'produto_id' => $request->input('produto_id'),
                'quantidade'=>1,
                'imagem'=>$request->input('produto_imagem'),
                'preco'=>$request->input('produto_preco'),
                'descricao'=>$request->input('produto_descricao'),
                'codigo_barras'=>$request->input('produto_codigo_barras')
            ]);

            $carrinho->save();
            DB::commit();
            return redirect()->back()->with('message', 'Item adicionado ao carrinho!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Erro ao adicionar item ao carrinho!'. $th->getMessage()]);
        }
    }

    public function destroy(string $id)
    {
        try{
            DB::beginTransaction();
            $carrinho = Carrinho::find($id);
            $carrinho->delete();
            DB::commit();
            return redirect()->back()->with('message', 'Item removido do carrinho!');
        }catch (\Throwable $th){
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Erro ao remover item do carrinho!']);
        }
    }
}
