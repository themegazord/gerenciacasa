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
    Schema::table('receitas', function (Blueprint $table) {
      $table->float('valor_aberto')->after('valor');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('receitas', function (Blueprint $table) {
      $table->dropColumn('valor_aberto');
    });
  }
};
