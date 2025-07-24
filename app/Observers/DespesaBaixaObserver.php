<?php

namespace App\Observers;

use App\Models\Banco;
use App\Models\Despesa;
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
    DB::transaction(function () use ($despesaBaixa) {
      $originalDespesaId = $despesaBaixa->getOriginal('despesa_id');
      $originalBancoId = $despesaBaixa->getOriginal('banco_id');
      $originalValor = $despesaBaixa->getOriginal('valor');

      $banco = $despesaBaixa->banco()->get()->first();
      $despesa = $despesaBaixa->despesa()->get()->first();

      $novodespesaId = $despesaBaixa->despesa_id;

      if ($originalDespesaId !== $novodespesaId) {
        $despesaAntiga = Despesa::find($originalDespesaId);
        $bancoAntigo = Banco::find($originalBancoId);

        $despesaAntiga->update([
          'valor_aberto' => $despesaAntiga->valor,
          'status' => true,
        ]);

        if ($banco->id !== $bancoAntigo->id) {
          $bancoAntigo->update([
            'saldo_atual' => $bancoAntigo->saldo_atual - $originalValor,
          ]);

          $banco->update([
            'saldo_atual' => $banco->saldo_atual + $despesaBaixa->valor
          ]);
        } else {
          $banco->update([
            'saldo_atual' => ($banco->saldo_atual - $originalValor) + $despesaBaixa->valor
          ]);
        }

        $novoValorAberto = max(0, $despesa->valor_aberto - $despesaBaixa->valor);

        $despesa->update([
          'valor_aberto' => $novoValorAberto,
          'status' => $novoValorAberto > 0
        ]);
      } else {

        if (!$banco || !$despesa) {
          return;
        }

        $valorAnterior = $originalValor;
        $valorAtual = $despesaBaixa->valor;
        $diferenca = $valorAtual - $valorAnterior;

        if ($diferenca !== 0) {
          $banco->update([
            'saldo_atual' => $banco->saldo_atual + $diferenca,
          ]);

          $novoValorAberto = max(0, $despesa->valor_aberto - $diferenca);
          $despesa->update([
            'valor_aberto' => $novoValorAberto,
            'status' => $novoValorAberto > 0,
          ]);
        }
      }
    });
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
