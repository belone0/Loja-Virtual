<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $fillable = [
        'user_id',
        'produto_id',
        'quantidade',
        'imagem',
        'descricao',
        'preco',
        'codigo_barras'
    ];

    protected $table = 'carrinho';

}
