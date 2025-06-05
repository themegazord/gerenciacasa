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
    Schema::create('despesas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
      $table->foreignId('banco_id')->constrained('bancos')->cascadeOnDelete();
      $table->foreignId('categoria_id')->constrained('categoria_financas')->cascadeOnDelete();
      $table->foreignId('despesa_pai_id')->nullable()->constrained('despesas')->cascadeOnDelete();
      $table->boolean('status')->default(true);
      $table->string('descricao');
      $table->float('valor');
      $table->float('valor_aberto');
      $table->date('data_vencimento');
      $table->text('observacao')->nullable();
      $table->boolean('recorrente')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('despesas');
  }
};
