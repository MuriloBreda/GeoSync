<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('localizacoes', function (Blueprint $table) {
            $table->string('fonte', 30)->nullable()->after('remessa_id')->index();
        });
    }

    public function down(): void
    {
        Schema::table('localizacoes', function (Blueprint $table) {
            $table->dropIndex(['fonte']);
            $table->dropColumn('fonte');
        });
    }
};
