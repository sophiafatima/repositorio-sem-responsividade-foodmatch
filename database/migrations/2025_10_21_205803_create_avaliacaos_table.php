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
    Schema::create('avaliacoes', function (Blueprint $table) {
        $table->id('id_avaliacao');
        $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
        $table->integer('nota')->nullable();
        $table->string('comentario', 500)->nullable();
        $table->string('nome_usuario', 500)->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacaos');
    }
};
