<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remessas', function (Blueprint $table) {
            if (!Schema::hasColumn('remessas', 'destino_precisao')) {
                $table->string('destino_precisao', 20)->nullable();
            }
            if (!Schema::hasColumn('remessas', 'proximidade_notificada_at')) {
                $table->timestamp('proximidade_notificada_at')->nullable();
            }
        });

        Schema::table('localizacoes', function (Blueprint $table) {
            if (!Schema::hasColumn('localizacoes', 'fonte')) {
                $table->string('fonte', 30)->nullable()->default('esp32');
            }
            $table->index(['remessa_id', 'created_at'], 'localizacoes_remessa_created_idx');
        });
    }

    public function down(): void
    {
        Schema::table('localizacoes', function (Blueprint $table) {
            $table->dropIndex('localizacoes_remessa_created_idx');
        });

        Schema::table('remessas', function (Blueprint $table) {
            if (Schema::hasColumn('remessas', 'destino_precisao')) {
                $table->dropColumn('destino_precisao');
            }
        });
    }
};
