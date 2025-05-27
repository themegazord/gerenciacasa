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
    Schema::create('categoria_financas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->string('nome');
      $table->enum('tipo', ['receita', 'despesa']);
      $table->string('cor')->nullable();
      $table->boolean('ativa')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('categoria_financas', function (Blueprint $table) {
      $table->dropForeign('categoria_financas_user_id_foreign');
    });
    Schema::dropIfExists('categoria_financas');
  }
};
