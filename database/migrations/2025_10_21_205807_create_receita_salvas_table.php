<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
{
    Schema::create('receita_salvas', function (Blueprint $table) {
        $table->foreignId('id_receita')->constrained('receitas', 'id_receita')->onDelete('cascade');
        $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
        $table->string('nome_receita', 500)->nullable();
        $table->string('descricao_receita', 500)->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receita_salvas');
    }
};
