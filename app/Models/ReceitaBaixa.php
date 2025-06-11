<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReceitaBaixa extends Model
{
  protected $fillable = [
    'user_id',
    'receita_id',
    'banco_id',
    'descricao',
    'valor',
    'data_baixa',
    'forma_pagamento',
    'observacoes',
    'conciliado',
    'conciliado_em',
  ];

  public function usuario(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function receita(): BelongsTo {
    return $this->belongsTo(Receita::class);
  }

  public function banco(): BelongsTo {
    return $this->belongsTo(Banco::class);
  }
}
