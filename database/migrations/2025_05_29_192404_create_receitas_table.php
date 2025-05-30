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
    Schema::create('receitas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
      $table->foreignId('banco_id')->constrained('bancos');
      $table->foreignId('categoria_id')->constrained('categoria_financas');
      $table->foreignId('receita_pai_id')->nullable()->constrained('receitas')->cascadeOnDelete();
      $table->string('descricao');
      $table->float('valor');
      $table->date('data');
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
    Schema::table('receitas', function (Blueprint $table) {
      $table->dropForeign('receitas_user_id_foreign');
      $table->dropForeign('receitas_banco_id_foreign');
      $table->dropForeign('receitas_categoria_id_foreign');
      $table->dropForeign('receitas_receita_pai_id_foreign');
    });
    Schema::dropIfExists('receitas');
  }
};
