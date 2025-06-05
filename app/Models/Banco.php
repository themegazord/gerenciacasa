<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banco extends Model
{
  use SoftDeletes;

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

  public function receitas(): HasMany {
    return $this->hasMany(Receita::class);
  }

  public function despesas(): HasMany {
    return $this->hasMany(Despesa::class);
  }

  public function tiposBancos(?string $tipo = null): string
  {
    return match ($tipo ?? $this->tipo) {
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
