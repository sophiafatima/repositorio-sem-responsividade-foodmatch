<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->string('foto_perfil')->nullable();
            $table->text('descricao')->nullable();
            $table->text('restricoes')->nullable();
        });
    }

    public function down()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn(['foto_perfil', 'descricao', 'restricoes']);
        });
    }
};