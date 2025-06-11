<?php

namespace App\Observers;

use App\Models\ReceitaBaixa;
use Illuminate\Support\Facades\DB;

class ReceitaBaixaObserver
{
  /**
   * Handle the ReceitaBaixa "created" event.
   */
  public function created(ReceitaBaixa $receitaBaixa): void
  {
    $banco = $receitaBaixa->banco;
    $receita = $receitaBaixa->receita;

    DB::transaction(function () use ($banco, $receita, $receitaBaixa) {
      $banco->update([
        'saldo_atual' => $banco->saldo_atual + $receitaBaixa->valor
      ]);

      $novo_valor_aberto = max(0, $receita->valor_aberto - $receitaBaixa->valor);
      $updates = ['valor_aberto' => $novo_valor_aberto];

      if (round($novo_valor_aberto, 2) <= 0) {
        $updates['status'] = false;
      }

      $receita->update($updates);
    });
  }

  /**
   * Handle the ReceitaBaixa "updated" event.
   */
  public function updated(ReceitaBaixa $receitaBaixa): void
  {
    //
  }

  /**
   * Handle the ReceitaBaixa "deleted" event.
   */
  public function deleted(ReceitaBaixa $receitaBaixa): void
  {
    $banco = $receitaBaixa->banco;
    $receita = $receitaBaixa->receita;

    DB::transaction(function () use ($banco, $receita, $receitaBaixa) {
      $banco->update([
        'saldo_atual' => $banco->saldo_atual - $receitaBaixa->valor
      ]);

      $updates = ['valor_aberto' => $receita->valor_aberto + $receitaBaixa->valor];

      if (!$receita->status) {
        $updates['status'] = true;
      }

      $receita->update($updates);
    });
  }

  /**
   * Handle the ReceitaBaixa "restored" event.
   */
  public function restored(ReceitaBaixa $receitaBaixa): void
  {
    //
  }

  /**
   * Handle the ReceitaBaixa "force deleted" event.
   */
  public function forceDeleted(ReceitaBaixa $receitaBaixa): void
  {
    //
  }
}
