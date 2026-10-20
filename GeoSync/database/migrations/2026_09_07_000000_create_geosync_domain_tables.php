<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('password');
            $table->string('foto')->nullable()->after('birth_date');
            $table->string('tipo', 20)->default('cliente')->after('foto');
            $table->string('telefone', 20)->nullable()->after('tipo');
            $table->string('cpf', 14)->nullable()->unique()->after('telefone');
            $table->boolean('dark_mode')->default(false)->after('cpf');
        });

        Schema::create('remessas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_rastreio', 100)->unique();
            $table->string('origem', 100);
            $table->string('destino', 100);
            $table->string('tipo_carga', 100)->nullable();
            $table->decimal('peso', 10, 2)->nullable();
            $table->date('previsao_entrega')->nullable();
            $table->string('status', 50)->default('Pendente');
            $table->foreignId('cliente_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('motorista_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 100);
            $table->text('mensagem');
            $table->foreignId('remessa_id')->constrained('remessas')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('valor', 10, 2);
            $table->string('status', 50)->default('Pendente');
            $table->timestamps();
        });

        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_exibicao')->nullable();
            $table->unsignedTinyInteger('nota');
            $table->string('comentario', 1000)->nullable();
            $table->timestamps();
        });

        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('email', 100);
            $table->text('mensagem');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contatos');
        Schema::dropIfExists('avaliacoes');
        Schema::dropIfExists('pagamentos');
        Schema::dropIfExists('alertas');
        Schema::dropIfExists('remessas');
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['cpf']);
            $table->dropColumn(['birth_date', 'foto', 'tipo', 'telefone', 'cpf', 'dark_mode']);
        });
    }
};
