<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
     Schema::create('usuario', function (Blueprint $table) {
    $table->id('id_usuario');
    $table->string('nome_usuario', 100);
    $table->string('email_usuario', 100)->unique();
    $table->string('senha_usuario', 150);
    $table->boolean('idioma')->nullable();
    $table->timestamp('data_criacao')->useCurrent();
});

  
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');

    }
};
