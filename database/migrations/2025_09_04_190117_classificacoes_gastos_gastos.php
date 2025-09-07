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
        //adicionar uma coluna em gastos 'tipo_gasto_id' que referencia tipos_gastos ecriar a chave estrangeira
        Schema::table('gastos', function (Blueprint $table) {
            $table->unsignedBigInteger('classificacao_gasto_id')->after('id');
            $table->foreign('classificacao_gasto_id')->references('id')->on('classificacoes_gastos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gastos', function (Blueprint $table) {
            $table->dropForeign(['classificacao_gasto_id']);
            $table->dropColumn('classificacao_gasto_id');
        });
    }
};
