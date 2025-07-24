<?php

namespace App\Observers;

use App\Models\DespesaBaixa;
use Illuminate\Support\Facades\DB;

class DespesaBaixaObserver
{
  /**
   * Handle the DespesaBaixa "created" event.
   */
  public function created(DespesaBaixa $despesaBaixa): void
  {
    $banco = $despesaBaixa->banco;
    $despesa = $despesaBaixa->despesa;

    DB::transaction(function () use ($banco, $despesa, $despesaBaixa) {
      $banco->update([
        'saldo_atual' => $banco->saldo_atual - $despesaBaixa->valor
      ]);

      $novoValorAberto = max(0, $despesa->valor_aberto - $despesaBaixa->valor);

      $despesa->update([
        'valor_aberto' => $novoValorAberto,
        'status' => $novoValorAberto > 0
      ]);
    });
  }

  /**
   * Handle the DespesaBaixa "updated" event.
   */
  public function updated(DespesaBaixa $despesaBaixa): void
  {
    //
  }

  /**
   * Handle the DespesaBaixa "deleted" event.
   */
  public function deleted(DespesaBaixa $despesaBaixa): void
  {
    //
  }

  /**
   * Handle the DespesaBaixa "restored" event.
   */
  public function restored(DespesaBaixa $despesaBaixa): void
  {
    //
  }

  /**
   * Handle the DespesaBaixa "force deleted" event.
   */
  public function forceDeleted(DespesaBaixa $despesaBaixa): void
  {
    //
  }
}
