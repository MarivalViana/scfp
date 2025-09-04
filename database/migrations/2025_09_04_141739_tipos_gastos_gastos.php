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
            $table->unsignedBigInteger('tipo_gasto_id')->after('id');
            $table->foreign('tipo_gasto_id')->references('id')->on('tipos_gastos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gastos', function (Blueprint $table) {
            $table->dropForeign(['tipo_gasto_id']);
            $table->dropColumn('tipo_gasto_id');
        });
    }
};
