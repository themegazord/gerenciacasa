<?php

namespace App\Observers;

use App\Models\Banco;
use App\Models\Receita;
use App\Models\ReceitaBaixa;
use Illuminate\Support\Facades\DB;
use Mary\Traits\Toast;

class ReceitaBaixaObserver
{
  use Toast;
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

      $novoValorAberto = max(0, $receita->valor_aberto - $receitaBaixa->valor);

      $receita->update([
        'valor_aberto' => $novoValorAberto,
        'status' => $novoValorAberto > 0
      ]);
    });
  }

  /**
   * Handle the ReceitaBaixa "updated" event.
   */
  public function updated(ReceitaBaixa $receitaBaixa): void
  {
    DB::transaction(function () use ($receitaBaixa) {
      $originalReceitaId = $receitaBaixa->getOriginal('receita_id');
      $originalBancoId = $receitaBaixa->getOriginal('banco_id');
      $originalValor = $receitaBaixa->getOriginal('valor');

      $banco = $receitaBaixa->banco()->get()->first();
      $receita = $receitaBaixa->receita()->get()->first();

      $novoReceitaId = $receitaBaixa->receita_id;

      if ($originalReceitaId !== $novoReceitaId) {
        $receitaAntiga = Receita::find($originalReceitaId);
        $bancoAntigo = Banco::find($originalBancoId);

        $receitaAntiga->update([
          'valor_aberto' => $receitaAntiga->valor,
          'status' => true,
        ]);

        if ($banco->id !== $bancoAntigo->id) {
          $bancoAntigo->update([
            'saldo_atual' => $bancoAntigo->saldo_atual - $originalValor,
          ]);

          $banco->update([
            'saldo_atual' => $banco->saldo_atual + $receitaBaixa->valor
          ]);
        } else {
          $banco->update([
            'saldo_atual' => ($banco->saldo_atual - $originalValor) + $receitaBaixa->valor
          ]);
        }

        $novoValorAberto = max(0, $receita->valor_aberto - $receitaBaixa->valor);

        $receita->update([
          'valor_aberto' => $novoValorAberto,
          'status' => $novoValorAberto > 0
        ]);
      } else {

        if (!$banco || !$receita) {
          return;
        }

        $valorAnterior = $originalValor;
        $valorAtual = $receitaBaixa->valor;
        $diferenca = $valorAtual - $valorAnterior;

        if ($diferenca !== 0) {
          $banco->update([
            'saldo_atual' => $banco->saldo_atual + $diferenca,
          ]);

          $novoValorAberto = max(0, $receita->valor_aberto - $diferenca);
          $receita->update([
            'valor_aberto' => $novoValorAberto,
            'status' => $novoValorAberto > 0,
          ]);
        }
      }
    });
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
  public function restored(ReceitaBaixa $receitaBaixa): void {}

  /**
   * Handle the ReceitaBaixa "force deleted" event.
   */
  public function forceDeleted(ReceitaBaixa $receitaBaixa): void {}
}
