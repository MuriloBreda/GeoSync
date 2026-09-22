<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('remessas', function (Blueprint $table) {
            $table->string('destino', 255)->change();
            $table->string('destino_cep', 9)->nullable()->after('destino');
            $table->string('destino_rua', 150)->nullable()->after('destino_cep');
            $table->string('destino_numero', 20)->nullable()->after('destino_rua');
            $table->string('destino_complemento', 150)->nullable()->after('destino_numero');
            $table->string('destino_bairro', 100)->nullable()->after('destino_complemento');
            $table->string('destino_cidade', 100)->nullable()->after('destino_bairro');
            $table->string('destino_estado', 2)->nullable()->after('destino_cidade');
            $table->decimal('latitude_destino', 10, 7)->nullable()->after('destino_estado');
            $table->decimal('longitude_destino', 10, 7)->nullable()->after('latitude_destino');
            $table->timestamp('proximidade_notificada_at')->nullable()->after('longitude_destino');
        });
    }

    public function down(): void
    {
        Schema::table('remessas', function (Blueprint $table) {
            $table->dropColumn([
                'destino_cep', 'destino_rua', 'destino_numero', 'destino_complemento',
                'destino_bairro', 'destino_cidade', 'destino_estado', 'latitude_destino',
                'longitude_destino', 'proximidade_notificada_at',
            ]);
        });
    }
};
