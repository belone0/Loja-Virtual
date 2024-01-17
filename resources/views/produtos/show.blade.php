@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-center">
                            <span class="display-6" id="title"></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mt-3 d-flex justify-content-center">
                            <img class="img-fluid rounded" width="400" height="400" src="{{$data->imagem}}">
                        </div>
                        <div class="mt-4 d-flex justify-content-center">
                            <span class="fs-2" id="descricao">{{$data->descricao}}</span>
                        </div>
                        <div class="d-flex justify-content-center">
                            <span class="fs-3" id="type"></span>
                        </div>
                        <div class="d-flex justify-content-center">
                            <span class="fs-3" id="value">Valor: R$ {{$data->tipo_preco['0']->preco}}</span>
                        </div>
                        <div class=" d-flex justify-content-center">
                            <span class="fs-3"
                                  id="value">Quantidade em estoque: {{$data->quantidade}}</span>
                        </div>
                        <div class="mt-5 d-flex justify-content-center">
                            <div class="mb-3">{!! DNS1D::getBarcodeHTML($data->codigo_barras, 'CODABAR') !!}</div>
                        </div>
                        <div class="mt-3 mb-2 d-flex justify-content-center">
                            @guest()
                                <a href="{{route('login')}}" class="btn btn-primary">
                                    Adicionar ao carrinho
                                </a>
                            @else
                                @if($available)
                                    <form action="{{ route('carrinho.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$data->imagem}}" name="produto_imagem">
                                        <input type="hidden" value="{{$data->descricao}}" name="produto_descricao">
                                        <input type="hidden" value="{{ $data->id }}" name="produto_id">
                                        <input type="hidden" value="{{ $data->tipo_preco['0']->preco}}"
                                               name="produto_preco">
                                        <input type="hidden" value="{{ $data->codigo_barras}}"
                                               name="produto_codigo_barras">
                                        <input type="hidden" value="0" name="produto_quantidade">
                                        <button id="add-cart" type="submit" class="btn btn-primary">
                                            Adicionar ao carrinho
                                        </button>
                                        @endif
                                    </form>
                                @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
