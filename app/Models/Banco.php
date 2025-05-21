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

  public function usuario(): BelongsTo {
    return $this->belongsTo(User::class);
  }
}
