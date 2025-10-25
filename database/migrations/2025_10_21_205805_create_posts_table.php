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
    Schema::create('posts', function (Blueprint $table) {
        $table->id('id_post');
        $table->string('titulo_post', 200);
        $table->string('descricao_post', 500);
        $table->string('nome_usuario', 500)->nullable();
        $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
