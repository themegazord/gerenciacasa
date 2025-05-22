<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banco extends Model
{
  protected $fillable = [
    'user_id',
    'nome',
    'tipo',
    'saldo_inicial',
    'saldo_atual',
    'agencia',
    'numero_conta',
    'ativo',
    'descricao',
  ];

  public function usuario(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function tiposBancos(string $tipo): string
  {
    return match ($tipo) {
      'corrente' => 'Conta Corrente',
      'poupanca' => 'Conta Poupança',
      'carteira' => 'Carteira Física',
      'digital' => 'Conta Digital',
      'investimento' => 'Investimentos',
      'caixa_empresa' => 'Caixa da Empresa',
      'cartao_credito' => 'Cartão de Crédito',
      'moeda_estrangeira' => 'Conta em Moeda Estrangeira',
      'outro' => 'Outro'
    };
  }
}
