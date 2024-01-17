@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p class=" text-center display-6">Carrinho de compras</p>
                <div class="card">
                    <div class="card-body">
                        <div id="products-div" class="row d-flex justify-content-center ">
                            @if($carrinho->count() > 0)
                                <div class="col-12 col-md-6">
                                    @if($precoTotal > 0)
                                        <form action="{{ route('venda') }}" method="post" class="needs-validation" novalidate>
                                            @csrf
                                            <p class="mt-5 text-center fs-2">Preço Total: R$ {{$precoTotal}}</p>
                                            <div class="d-flex justify-content-center">
                                                <input type="hidden" value="{{$precoTotal}}" name="preco_total">
                                                <div class="w-50">
                                                <input class="form-control input-group" type="text" value="" name="cpf" placeholder="Insira seu CPF" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Informe um CPF válido (XXX.XXX.XXX-XX)">
                                                <div class="invalid-feedback">
                                                    Por favor, informe um CPF válido.
                                                </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="mt-5 btn btn-primary rounded p-2">
                                                    Finalizar Compra
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                <div class="col-12 col-md-6">
                                    @foreach($carrinho as $item)
                                        <div class="mb-2 imovel_link d-flex rounded p-2">
                                            <a href="{{route('produtos.show', $item->produto_id)}}">
                                                <div class="mt-3 d-flex justify-content-center">
                                                    <img class=" rounded" width="75" height="75"
                                                         src="{{$item->imagem}}" alt="">
                                                </div>
                                            </a>
                                            <div class="w-100 row">
                                                <div class="col-12 col-md-8">
                                                    <div class="d-flex justify-content-center">
                                                        <a class="mt-1 text-center text-decoration-none text-black fs-4"
                                                           href="{{route('produtos.show', $item->produto_id)}}">{{$item->descricao}}</a>
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <span>R$ {{$item->preco ?? 'Indefinido'}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-3">
                                                    <span>Quantidade: {{$item->quantidade}}</span>
                                                    <form action="{{route('carrinho.destroy', $item->id)}}"
                                                          method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="mt-2 btn btn-danger">
                                                            Remover
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div id="no-results">
                                    <p class="mb-0 text-center fs-2">Ainda não tem nada por aqui...</p>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{route('produtos.index')}}" class="btn btn-primary mt-2 ">
                                            Ver produtos
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('carrinho.scripts.index')
@endsection
