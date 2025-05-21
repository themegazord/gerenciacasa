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
    Schema::create('bancos', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
      $table->string('nome');
      $table->string('tipo');
      $table->float('saldo_inicial');
      $table->float('saldo_atual');
      $table->string('agencia')->nullable();
      $table->string('numero_conta')->nullable();
      $table->boolean('ativo')->default(true);
      $table->text('descricao')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('bancos', function (Blueprint $table) {
      $table->dropForeign('bancos_user_id_foreign');
    });
    Schema::dropIfExists('bancos');
  }
};
