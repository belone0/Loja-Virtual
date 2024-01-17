@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <p class=" text-center display-6">Produtos Disponíveis</p>
                <div class="card card-body mb-4">
                    <div class="d-flex row p-2 justify-content-around">
                        <div class="col-12 col-md-9">
                            <input id="search-box" class=" form-control" type="text"
                                   placeholder="Buscar">
                        </div>
                        <button id="search-btn" type="submit" class="mt-2 mt-md-0 col-12 col-md-2 btn btn-primary">
                            Buscar
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div id="products-div" class="row d-flex justify-content-center gap-4 p-3">
                            @forelse($allProducts as $produto)
                                <div class="imovel_link  col-12 col-md-6 col-lg-3 rounded p-2">
                                    <a id="imovel_link" class=" text-black text-decoration-none"
                                       href="{{route('produtos.show', $produto->id)}}">
                                        <div class="mt-3 d-flex justify-content-center">
                                            <img class=" rounded" width="150" height="150"
                                                 src="{{$produto->imagem}}" alt="">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                                <span class="mt-1 text-center fs-4"
                                                      id="title">{{$produto->descricao}}</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                                <span
                                                    id="address">R$ {{$produto->tipo_preco['0']->preco ?? 'Indefinido'}}</span>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div id="no-results" class="d-none">
                                    <p class="mb-0 text-center fs-2">Ainda não tem nada por aqui...</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
{{--                <div class="mt-3  d-flex justify-content-between">--}}
{{--                    <a class="btn btn-primary" href="{{route('produtos.index')}}">Anterior</a>--}}
{{--                    <a class="btn btn-primary" href="{{route('produtos.index')}}">Próximo</a>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    @include('produtos.scripts.index')
@endsection
