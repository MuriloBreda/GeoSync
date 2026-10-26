<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->string('email')->nullable()->after('user_id');
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropColumn('email');
            // Pagamentos feitos antes desta alteração podem não ter um usuário vinculado.
            // A coluna permanece nullable para que o rollback não apague dados.
        });
    }
};
