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
    Schema::create('despesa_baixas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
      $table->foreignId('despesa_id')->constrained('despesas');
      $table->foreignId('banco_id')->constrained('bancos')->cascadeOnDelete();
      $table->string('descricao', 100);
      $table->float('valor');
      $table->date('data_baixa');
      $table->string('forma_pagamento')->nullable();
      $table->text('observacoes')->nullable();
      $table->boolean('conciliado')->default(false);
      $table->timestamp('conciliado_em')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('despesa_baixas');
  }
};
