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
    Schema::create('lista_de_compras', function (Blueprint $table) {
        $table->foreignId('id_receita')->constrained('receitas', 'id_receita')->onDelete('cascade');
        $table->string('recomendacao', 500)->nullable();
        $table->string('ingredientes', 500);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_de_compras');
    }
};
