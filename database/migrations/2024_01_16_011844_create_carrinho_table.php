<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carrinho', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(\App\Models\User::class);
            $table->integer('produto_id');
            $table->integer('quantidade');
            $table->decimal('preco');
            $table->string('imagem');
            $table->string('descricao');
            $table->string('codigo_barras');
        });
    }
};
