<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DespesaBaixa extends Model
{
  protected $fillable = [
    'user_id',
    'despesa_id',
    'banco_id',
    'descricao',
    'valor',
    'data_baixa',
    'forma_pagamento',
    'observacoes',
    'conciliado',
    'conciliado_em',
  ];

  public function usuario(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function despesa(): BelongsTo
  {
    return $this->belongsTo(Despesa::class);
  }

  public function banco(): BelongsTo
  {
    return $this->belongsTo(Banco::class);
  }
}
