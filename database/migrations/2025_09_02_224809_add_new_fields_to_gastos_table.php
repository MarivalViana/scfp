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
        Schema::table('gastos', function (Blueprint $table) {
            $table->boolean('compartilhado')->default(false)->after('valor');
            $table->boolean('repeticao')->default(false)->after('compartilhado');
            $table->boolean('valor_dividido')->default(false)->after('repeticao');
            $table->boolean('anual')->default(false)->after('valor_dividido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('gastos', function (Blueprint $table) {
            $table->dropColumn(['compartilhado', 'repeticao', 'valor_dividido', 'anual']);
        });
    }
};
